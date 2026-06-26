<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\KartuStok;
use App\Models\Rak;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\TransaksiRetur;
use App\Models\TransaksiReturItem;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiReturController extends Controller
{

    public function index(Request $request)
    {
        $returs = TransaksiRetur::with(['transaksi', 'supplier', 'gudang'])
            ->when($request->search, fn($q) => $q->where('nomor_retur', 'like', '%' . $request->search . '%'))
            ->when($request->jenis_retur, fn($q) => $q->where('jenis_retur', $request->jenis_retur))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->gudang_id, fn($q) => $q->where('gudang_id', $request->gudang_id))
            ->latest()->paginate(10)->withQueryString();

        $gudangs = Gudang::where('status', 'aktif')->get();

        return view('transaksi-retur.index', compact('returs', 'gudangs'));
    }

    public function create(Request $request)
    {
        // Retur harus berdasarkan transaksi yang sudah ada
        $transaksis = Transaksi::with('supplier', 'gudang')
            ->where('status', 'selesai')
            ->latest()->get();

        $suppliers = Supplier::where('status', 'aktif')->get();
        $gudangs   = Gudang::where('status', 'aktif')->get();

        // Jika ada transaksi_id di query string, preload item-itemnya
        $transaksiTerpilih = null;
        if ($request->transaksi_id) {
            $transaksiTerpilih = Transaksi::with('items.varianProduk.produk', 'items.rak')
                ->find($request->transaksi_id);
        }

        return view('transaksi-retur.create', compact('transaksis', 'suppliers', 'gudangs', 'transaksiTerpilih'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id'    => 'required|exists:transaksis,id',
            'gudang_id'       => 'required|exists:gudangs,id',
            'jenis_retur'     => 'required|in:retur_masuk,retur_keluar',
            'tanggal_retur'   => 'required|date',
            'alasan_retur'    => 'required|string',
            'keterangan'      => 'nullable|string',
            'items'           => 'required|array|min:1',
            'items.*.varian_produk_id'    => 'required|exists:varian_produks,id',
            'items.*.transaksi_item_id'   => 'nullable|exists:transaksi_items,id',
            'items.*.qty_retur'           => 'required|integer|min:1',
            'items.*.kondisi_barang'      => 'required|in:baik,rusak,cacat,kadaluarsa',
            'items.*.keterangan_kondisi'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $transaksi = Transaksi::find($request->transaksi_id);
            $nomor     = TransaksiRetur::generateNomor();

            $retur = TransaksiRetur::create([
                'nomor_retur'    => $nomor,
                'transaksi_id'   => $request->transaksi_id,
                'supplier_id'    => $transaksi->supplier_id,
                'gudang_id'      => $request->gudang_id,
                'jenis_retur'    => $request->jenis_retur,
                'tanggal_retur'  => $request->tanggal_retur,
                'status'         => 'selesai',
                'alasan_retur'   => $request->alasan_retur,
                'petugas'        => Auth::user()->name,
                'keterangan'     => $request->keterangan,
            ]);

            foreach ($request->items as $item) {
                TransaksiReturItem::create([
                    'transaksi_retur_id'   => $retur->id,
                    'varian_produk_id'     => $item['varian_produk_id'],
                    'transaksi_item_id'    => $item['transaksi_item_id'] ?? null,
                    'nomor_batch'          => $item['nomor_batch'] ?? null,
                    'qty_retur'            => $item['qty_retur'],
                    'kondisi_barang'       => $item['kondisi_barang'],
                    'keterangan_kondisi'   => $item['keterangan_kondisi'] ?? null,
                ]);

                $varian = VarianProduk::find($item['varian_produk_id']);

                // retur_masuk = barang kembali ke gudang (stok naik)
                // retur_keluar = barang keluar dari gudang ke supplier (stok turun)
                if ($request->jenis_retur === 'retur_masuk') {
                    $stokBaru = $varian->stok_varian + $item['qty_retur'];
                    $jenisKartu = 'retur';
                    $masuk = $item['qty_retur'];
                    $keluar = 0;
                } else {
                    $stokBaru = $varian->stok_varian - $item['qty_retur'];
                    $jenisKartu = 'retur';
                    $masuk = 0;
                    $keluar = $item['qty_retur'];
                }

                $varian->update(['stok_varian' => $stokBaru]);

                KartuStok::create([
                    'varian_produk_id' => $item['varian_produk_id'],
                    'gudang_id'        => $request->gudang_id,
                    'nomor_transaksi'  => $nomor,
                    'jenis_transaksi'  => $jenisKartu,
                    'jumlah_masuk'     => $masuk,
                    'jumlah_keluar'    => $keluar,
                    'stok_akhir'       => $stokBaru,
                    'petugas'          => Auth::user()->name,
                    'keterangan'       => "Retur: {$request->alasan_retur}",
                ]);
            }
        });

        return redirect()->route('transaksi-retur.index')->with('success', 'Transaksi retur berhasil disimpan.');
    }

    public function show(TransaksiRetur $transaksiRetur)
    {
        $transaksiRetur->load(['transaksi.supplier', 'gudang', 'items.varianProduk.produk']);
        return view('transaksi-retur.show', compact('transaksiRetur'));
    }

    // API: ambil items dari transaksi tertentu untuk form retur
    public function getItemsByTransaksi(Transaksi $transaksi)
    {
        $items = $transaksi->items()->with('varianProduk.produk', 'rak')->get();
        return response()->json($items);
    }
}
