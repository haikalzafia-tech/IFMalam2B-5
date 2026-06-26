<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\KartuStok;
use App\Models\KelebihanKapasitas;
use App\Models\LokasiStok;
use App\Models\Rak;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{

    // ===================== TRANSAKSI MASUK =====================

    public function indexMasuk(Request $request)
    {
        $transaksis = Transaksi::with(['supplier', 'gudang'])
            ->where('jenis_transaksi', 'pemasukan')
            ->when($request->search, fn($q) => $q->where('nomor_transaksi', 'like', '%' . $request->search . '%'))
            ->when($request->supplier_id, fn($q) => $q->where('supplier_id', $request->supplier_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->gudang_id, fn($q) => $q->where('gudang_id', $request->gudang_id))
            ->latest()->paginate(10)->withQueryString();

        $suppliers = Supplier::where('status', 'aktif')->get();
        $gudangs   = Gudang::where('status', 'aktif')->get();

        return view('transaksi-masuk.index', compact('transaksis', 'suppliers', 'gudangs'));
    }

    public function createMasuk()
    {
        $suppliers = Supplier::where('status', 'aktif')->get();
        $gudangs   = Gudang::where('status', 'aktif')->get();
        $varianProduks = VarianProduk::with('produk', 'rak.zona.gudang')->get();

        return view('transaksi-masuk.create', compact('suppliers', 'gudangs', 'varianProduks'));
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'gudang_id'           => 'required|exists:gudangs,id',
            'supplier_id'         => 'nullable|exists:suppliers,id',
            'nomor_po'            => 'nullable|string|max:100',
            'nomor_surat_jalan'   => 'nullable|string|max:100',
            'tanggal_transaksi'   => 'required|date',
            'keterangan'          => 'nullable|string',
            'items'               => 'required|array|min:1',
            'items.*.varian_produk_id' => 'required|exists:varian_produks,id',
            'items.*.rak_id'      => 'required|exists:raks,id',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.nomor_batch' => 'nullable|string',
            'items.*.tanggal_produksi'  => 'nullable|date',
            'items.*.tanggal_kadaluarsa' => 'nullable|date',
            'items.*.kondisi'     => 'required|in:baik,rusak,cacat',
            'items.*.catatan'     => 'nullable|string',
        ]);

        $adaKelebihan = false;

        $transaksi = DB::transaction(function () use ($request, &$adaKelebihan) {
            $nomor = Transaksi::generateNomor('pemasukan');

            $transaksi = Transaksi::create([
                'nomor_transaksi'       => $nomor,
                'jenis_transaksi'       => 'pemasukan',
                'gudang_id'             => $request->gudang_id,
                'supplier_id'           => $request->supplier_id,
                'jumlah_barang'         => collect($request->items)->sum('qty'),
                'nomor_po'              => $request->nomor_po,
                'nomor_surat_jalan'     => $request->nomor_surat_jalan,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'tanggal_kadaluarsa_po' => $request->tanggal_kadaluarsa_po,
                'status'                => 'selesai',
                'keterangan'            => $request->keterangan,
                'petugas'               => Auth::user()->name,
            ]);

            foreach ($request->items as $item) {
                $rak = Rak::find($item['rak_id']);
                $sisaKapasitas = max(0, $rak->kapasitas_total - $rak->kapasitas_terpakai);
                $qtyDiminta = (int) $item['qty'];

                // Bagi qty: yang muat ke rak ini, dan yang kelebihan (jika ada)
                $qtyMuat  = min($qtyDiminta, $sisaKapasitas);
                $qtyLebih = $qtyDiminta - $qtyMuat;

                $transaksiItem = TransaksiItem::create([
                    'transaksi_id'       => $transaksi->id,
                    'varian_produk_id'   => $item['varian_produk_id'],
                    'rak_id'             => $item['rak_id'],
                    'nomor_batch'        => $item['nomor_batch'] ?? null,
                    'tanggal_produksi'   => $item['tanggal_produksi'] ?? null,
                    'tanggal_kadaluarsa' => $item['tanggal_kadaluarsa'] ?? null,
                    'qty'                => $qtyDiminta,
                    'kondisi'            => $item['kondisi'],
                    'catatan'            => $item['catatan'] ?? null,
                ]);

                // Barang TETAP dicatat masuk & stok TETAP bertambah penuh (sesuai surat jalan),
                // hanya alokasi fisik ke rak yang dibatasi sebesar sisa kapasitas.
                $varian   = VarianProduk::find($item['varian_produk_id']);
                $stokBaru = $varian->stok_varian + $qtyDiminta;
                $varian->update(['stok_varian' => $stokBaru, 'rak_id' => $item['rak_id']]);

                // Catat/tambah stok di lokasi (rak) spesifik ini — barang bisa tersebar di banyak rak
                if ($qtyMuat > 0) {
                    LokasiStok::updateOrCreate(
                        ['varian_produk_id' => $item['varian_produk_id'], 'rak_id' => $item['rak_id']],
                        []
                    )->increment('qty', $qtyMuat);
                }

                // Kapasitas rak hanya bertambah sebesar yang benar-benar muat
                if ($qtyMuat > 0) {
                    $rak->increment('kapasitas_terpakai', $qtyMuat);
                }

                KartuStok::create([
                    'varian_produk_id' => $item['varian_produk_id'],
                    'gudang_id'        => $request->gudang_id,
                    'rak_id'           => $item['rak_id'],
                    'nomor_transaksi'  => $nomor,
                    'jenis_transaksi'  => 'in',
                    'nomor_batch'      => $item['nomor_batch'] ?? null,
                    'jumlah_masuk'     => $qtyDiminta,
                    'jumlah_keluar'    => 0,
                    'stok_akhir'       => $stokBaru,
                    'petugas'          => Auth::user()->name,
                ]);

                // Jika ada kelebihan dari kapasitas rak, catat ke antrian resolusi
                if ($qtyLebih > 0) {
                    $adaKelebihan = true;
                    KelebihanKapasitas::create([
                        'transaksi_item_id' => $transaksiItem->id,
                        'varian_produk_id'  => $item['varian_produk_id'],
                        'rak_id'            => $item['rak_id'],
                        'qty_muat'          => $qtyMuat,
                        'qty_lebih'         => $qtyLebih,
                        'status'            => 'menunggu',
                    ]);
                }
            }

            return $transaksi;
        });

        if ($adaKelebihan) {
            return redirect()->route('transaksi-masuk.show', $transaksi)
                ->with('warning', 'Transaksi berhasil disimpan, namun ada barang yang melebihi kapasitas rak. Silakan selesaikan di bagian "Kelebihan Kapasitas" di bawah.');
        }

        return redirect()->route('transaksi-masuk.index')->with('success', 'Transaksi masuk berhasil disimpan.');
    }

    public function showMasuk(Transaksi $transaksi)
    {
        $transaksi->load(['supplier', 'gudang', 'items.varianProduk.produk', 'items.rak.zona']);

        $kelebihanKapasitas = KelebihanKapasitas::whereIn('transaksi_item_id', $transaksi->items->pluck('id'))
            ->where('status', 'menunggu')
            ->with('varianProduk.produk', 'rak.zona')
            ->get();

        return view('transaksi-masuk.show', compact('transaksi', 'kelebihanKapasitas'));
    }

    // ===================== TRANSAKSI KELUAR =====================

    public function indexKeluar(Request $request)
    {
        $transaksis = Transaksi::with(['gudang'])
            ->where('jenis_transaksi', 'pengeluaran')
            ->when($request->search, fn($q) => $q->where('nomor_transaksi', 'like', '%' . $request->search . '%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->gudang_id, fn($q) => $q->where('gudang_id', $request->gudang_id))
            ->latest()->paginate(10)->withQueryString();

        $gudangs = Gudang::where('status', 'aktif')->get();

        return view('transaksi-keluar.index', compact('transaksis', 'gudangs'));
    }

    public function createKeluar()
    {
        $gudangs = Gudang::where('status', 'aktif')->get();

        // Ambil semua varian yang punya stok di MINIMAL satu lokasi (rak)
        $varianProduks = VarianProduk::with('produk', 'lokasiStoks.rak.zona')
            ->where('stok_varian', '>', 0)->get();

        return view('transaksi-keluar.create', compact('gudangs', 'varianProduks'));
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'gudang_id'           => 'required|exists:gudangs,id',
            'penerima'            => 'required|string|max:255',
            'tujuan'              => 'nullable|string|max:255',
            'nomor_surat_jalan'   => 'nullable|string|max:100',
            'tanggal_transaksi'   => 'required|date',
            'keterangan'          => 'nullable|string',
            'items'               => 'required|array|min:1',
            'items.*.varian_produk_id' => 'required|exists:varian_produks,id',
            'items.*.rak_id'      => 'required|exists:raks,id',
            'items.*.qty'         => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Cek stok cukup DI RAK YANG DIPILIH (bukan cuma total varian)
            foreach ($request->items as $item) {
                $varian = VarianProduk::findOrFail($item['varian_produk_id']);
                $lokasi = LokasiStok::where('varian_produk_id', $item['varian_produk_id'])
                    ->where('rak_id', $item['rak_id'])
                    ->first();

                $stokDiRak = $lokasi->qty ?? 0;

                if ($stokDiRak < $item['qty']) {
                    $rak = Rak::find($item['rak_id']);
                    throw new \Exception("Stok {$varian->nama_varian} di rak {$rak->kode_rak} tidak mencukupi. Stok tersedia di rak ini: {$stokDiRak}");
                }
            }

            $nomor = Transaksi::generateNomor('pengeluaran');

            $transaksi = Transaksi::create([
                'nomor_transaksi'     => $nomor,
                'jenis_transaksi'     => 'pengeluaran',
                'gudang_id'           => $request->gudang_id,
                'jumlah_barang'       => collect($request->items)->sum('qty'),
                'nomor_surat_jalan'   => $request->nomor_surat_jalan,
                'tanggal_transaksi'   => $request->tanggal_transaksi,
                'status'              => 'selesai',
                'keterangan'          => $request->keterangan,
                'petugas'             => Auth::user()->name,
                'penerima'            => $request->penerima,
                'tujuan'              => $request->tujuan,
            ]);

            foreach ($request->items as $item) {
                TransaksiItem::create([
                    'transaksi_id'     => $transaksi->id,
                    'varian_produk_id' => $item['varian_produk_id'],
                    'rak_id'           => $item['rak_id'],
                    'qty'              => $item['qty'],
                    'kondisi'          => $item['kondisi'] ?? 'baik',
                    'catatan'          => $item['catatan'] ?? null,
                ]);

                // Kurangi stok TOTAL varian
                $varian   = VarianProduk::find($item['varian_produk_id']);
                $stokBaru = $varian->stok_varian - $item['qty'];
                $varian->update(['stok_varian' => $stokBaru]);

                // Kurangi stok di LOKASI (rak) spesifik yang dipilih
                LokasiStok::where('varian_produk_id', $item['varian_produk_id'])
                    ->where('rak_id', $item['rak_id'])
                    ->decrement('qty', $item['qty']);

                Rak::find($item['rak_id'])->decrement('kapasitas_terpakai', $item['qty']);

                KartuStok::create([
                    'varian_produk_id' => $item['varian_produk_id'],
                    'gudang_id'        => $request->gudang_id,
                    'rak_id'           => $item['rak_id'],
                    'nomor_transaksi'  => $nomor,
                    'jenis_transaksi'  => 'out',
                    'jumlah_masuk'     => 0,
                    'jumlah_keluar'    => $item['qty'],
                    'stok_akhir'       => $stokBaru,
                    'petugas'          => Auth::user()->name,
                ]);
            }
        });

        return redirect()->route('transaksi-keluar.index')->with('success', 'Transaksi keluar berhasil disimpan.');
    }

    public function showKeluar(Transaksi $transaksi)
    {
        $transaksi->load(['gudang', 'items.varianProduk.produk', 'items.rak.zona']);
        return view('transaksi-keluar.show', compact('transaksi'));
    }
}
