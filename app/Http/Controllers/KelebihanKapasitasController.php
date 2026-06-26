<?php

namespace App\Http\Controllers;

use App\Models\KartuStok;
use App\Models\KelebihanKapasitas;
use App\Models\Rak;
use App\Models\TransaksiRetur;
use App\Models\TransaksiReturItem;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelebihanKapasitasController extends Controller
{
    // Daftar semua kelebihan kapasitas yang masih menunggu resolusi (lintas transaksi)
    public function index(Request $request)
    {
        $daftar = KelebihanKapasitas::with('varianProduk.produk', 'rak.zona.gudang', 'transaksiItem.transaksi')
            ->where('status', 'menunggu')
            ->when($request->gudang_id, fn($q) => $q->whereHas('rak.zona', fn($q2) => $q2->where('gudang_id', $request->gudang_id)))
            ->latest()
            ->paginate(15);

        return view('kelebihan-kapasitas.index', compact('daftar'));
    }

    // Tampilkan opsi rak lain yang masih ada sisa kapasitas, untuk dipilih
    public function getOpsiRak(KelebihanKapasitas $kelebihanKapasitas)
{
 //   dd($kelebihanKapasitas->id, $kelebihanKapasitas->rak_id, $kelebihanKapasitas->rak);
    $rakSekarang = $kelebihanKapasitas->rak;

        $opsiRak = Rak::where('zona_id', $rakSekarang->zona_id)
            ->where('id', '!=', $rakSekarang->id)
            ->where('status', 'aktif')
            ->get()
            ->filter(fn($r) => $r->sisa_kapasitas >= $kelebihanKapasitas->qty_lebih)
            ->map(fn($r) => [
                'id' => $r->id,
                'label' => "{$r->kode_rak} - {$r->nama_rak} (sisa: {$r->sisa_kapasitas})",
            ])
            ->values();

        return response()->json($opsiRak);
    }

    // OPSI 1: Pindahkan kelebihan barang ke rak lain
    public function pindahRak(Request $request, KelebihanKapasitas $kelebihanKapasitas)
    {
        $request->validate([
            'rak_tujuan_id' => 'required|exists:raks,id|different:kelebihanKapasitas.rak_id',
        ]);

        if ($kelebihanKapasitas->status !== 'menunggu') {
            return back()->with('error', 'Kelebihan kapasitas ini sudah diselesaikan sebelumnya.');
        }

        $rakTujuan = Rak::find($request->rak_tujuan_id);

        if ($rakTujuan->sisa_kapasitas < $kelebihanKapasitas->qty_lebih) {
            return back()->with('error', 'Rak tujuan tidak memiliki cukup sisa kapasitas.');
        }

        DB::transaction(function () use ($request, $kelebihanKapasitas, $rakTujuan) {
            // Tambahkan kapasitas terpakai di rak tujuan
            $rakTujuan->increment('kapasitas_terpakai', $kelebihanKapasitas->qty_lebih);

            // Catat di kartu stok sebagai transfer
            KartuStok::create([
                'varian_produk_id' => $kelebihanKapasitas->varian_produk_id,
                'gudang_id'        => $rakTujuan->zona->gudang_id,
                'rak_id'           => $rakTujuan->id,
                'nomor_transaksi'  => $kelebihanKapasitas->transaksiItem->transaksi->nomor_transaksi ?? null,
                'jenis_transaksi'  => 'transfer',
                'jumlah_masuk'     => $kelebihanKapasitas->qty_lebih,
                'jumlah_keluar'    => 0,
                'stok_akhir'       => $kelebihanKapasitas->varianProduk->stok_varian,
                'petugas'          => Auth::user()->name,
                'keterangan'       => "Pemindahan kelebihan kapasitas dari rak {$kelebihanKapasitas->rak->kode_rak}",
            ]);

            $kelebihanKapasitas->update([
                'status'            => 'dipindah_rak',
                'rak_tujuan_id'     => $rakTujuan->id,
                'diselesaikan_oleh' => Auth::user()->name,
                'diselesaikan_pada' => now(),
            ]);
        });

        return redirect()->back()->with('success', "Kelebihan barang berhasil dipindahkan ke rak {$rakTujuan->kode_rak}.");
    }

    // OPSI 2: Retur kelebihan barang ke supplier
    public function returKelebihan(Request $request, KelebihanKapasitas $kelebihanKapasitas)
    {
        $request->validate([
            'alasan_retur' => 'required|string',
        ]);

        if ($kelebihanKapasitas->status !== 'menunggu') {
            return back()->with('error', 'Kelebihan kapasitas ini sudah diselesaikan sebelumnya.');
        }

        DB::transaction(function () use ($request, $kelebihanKapasitas) {
            $transaksiAsal = $kelebihanKapasitas->transaksiItem->transaksi;
            $varian        = $kelebihanKapasitas->varianProduk;

            $nomorRetur = TransaksiRetur::generateNomor();

            $retur = TransaksiRetur::create([
                'nomor_retur'   => $nomorRetur,
                'transaksi_id'  => $transaksiAsal->id,
                'supplier_id'   => $transaksiAsal->supplier_id,
                'gudang_id'     => $transaksiAsal->gudang_id,
                'jenis_retur'   => 'retur_keluar',
                'tanggal_retur' => now()->toDateString(),
                'status'        => 'selesai',
                'alasan_retur'  => 'Kelebihan kapasitas rak: ' . $request->alasan_retur,
                'petugas'       => Auth::user()->name,
                'keterangan'    => "Retur otomatis akibat kelebihan kapasitas di rak {$kelebihanKapasitas->rak->kode_rak}",
            ]);

            TransaksiReturItem::create([
                'transaksi_retur_id'  => $retur->id,
                'varian_produk_id'    => $kelebihanKapasitas->varian_produk_id,
                'transaksi_item_id'   => $kelebihanKapasitas->transaksi_item_id,
                'qty_retur'           => $kelebihanKapasitas->qty_lebih,
                'kondisi_barang'      => 'baik',
                'keterangan_kondisi'  => 'Dikembalikan karena tidak ada kapasitas rak tersedia',
            ]);

            // Stok varian dikurangi karena barang lebih ini balik ke supplier
            $stokBaru = $varian->stok_varian - $kelebihanKapasitas->qty_lebih;
            $varian->update(['stok_varian' => $stokBaru]);

            KartuStok::create([
                'varian_produk_id' => $kelebihanKapasitas->varian_produk_id,
                'gudang_id'        => $transaksiAsal->gudang_id,
                'nomor_transaksi'  => $nomorRetur,
                'jenis_transaksi'  => 'retur',
                'jumlah_masuk'     => 0,
                'jumlah_keluar'    => $kelebihanKapasitas->qty_lebih,
                'stok_akhir'       => $stokBaru,
                'petugas'          => Auth::user()->name,
                'keterangan'       => 'Retur otomatis: kelebihan kapasitas rak',
            ]);

            $kelebihanKapasitas->update([
                'status'             => 'diretur',
                'transaksi_retur_id' => $retur->id,
                'diselesaikan_oleh'  => Auth::user()->name,
                'diselesaikan_pada'  => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Kelebihan barang berhasil diretur ke supplier.');
    }
}
