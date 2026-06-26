<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\KartuStok;
use App\Models\StokOpname;
use App\Models\StokOpnameItem;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{

    public function index(Request $request)
    {
        $opnames = StokOpname::with('gudang')
            ->when($request->gudang_id, fn($q) => $q->where('gudang_id', $request->gudang_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();

        $gudangs = Gudang::where('status', 'aktif')->get();

        return view('stok-opname.index', compact('opnames', 'gudangs'));
    }

    public function create()
    {
        $gudangs = Gudang::where('status', 'aktif')->get();
        return view('stok-opname.create', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gudang_id'       => 'required|exists:gudangs,id',
            'tanggal_opname'  => 'required|date',
            'keterangan'      => 'nullable|string',
        ]);

        $nomor   = StokOpname::generateNomor();
        $varianProduks = VarianProduk::whereHas('rak.zona', fn($q) => $q->where('gudang_id', $request->gudang_id))->get();

        $opname = StokOpname::create([
            'nomor_opname'   => $nomor,
            'gudang_id'      => $request->gudang_id,
            'tanggal_opname' => $request->tanggal_opname,
            'status'         => 'berlangsung',
            'petugas'        => Auth::user()->name,
            'keterangan'     => $request->keterangan,
        ]);

        // Pre-fill item dengan stok sistem saat ini
        foreach ($varianProduks as $varian) {
            StokOpnameItem::create([
                'stok_opname_id'  => $opname->id,
                'varian_produk_id' => $varian->id,
                'rak_id'          => $varian->rak_id,
                'stok_sistem'     => $varian->stok_varian,
                'stok_fisik'      => 0,
            ]);
        }

        return redirect()->route('stok-opname.show', $opname)->with('success', 'Stok opname dimulai. Silakan isi stok fisik.');
    }

    public function show(StokOpname $stokOpname)
    {
        $stokOpname->load(['gudang', 'items.varianProduk.produk', 'items.rak.zona']);
        return view('stok-opname.show', compact('stokOpname'));
    }

    public function update(Request $request, StokOpname $stokOpname)
    {
        $request->validate([
            'items'               => 'required|array',
            'items.*.id'          => 'required|exists:stok_opname_items,id',
            'items.*.stok_fisik'  => 'required|integer|min:0',
            'items.*.keterangan'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $stokOpname) {
            foreach ($request->items as $itemData) {
                $item = StokOpnameItem::find($itemData['id']);
                $item->update([
                    'stok_fisik'  => $itemData['stok_fisik'],
                    'keterangan'  => $itemData['keterangan'] ?? null,
                ]);
            }

            $stokOpname->update(['status' => 'selesai']);

            // Sesuaikan stok varian dan catat kartu stok untuk yang ada selisih
            foreach ($stokOpname->items as $item) {
                if ($item->selisih !== 0) {
                    $varian = $item->varianProduk;
                    $varian->update(['stok_varian' => $item->stok_fisik]);

                    KartuStok::create([
                        'varian_produk_id' => $varian->id,
                        'gudang_id'        => $stokOpname->gudang_id,
                        'rak_id'           => $item->rak_id,
                        'nomor_transaksi'  => $stokOpname->nomor_opname,
                        'jenis_transaksi'  => 'adjustment',
                        'jumlah_masuk'     => $item->selisih > 0 ? $item->selisih : 0,
                        'jumlah_keluar'    => $item->selisih < 0 ? abs($item->selisih) : 0,
                        'stok_akhir'       => $item->stok_fisik,
                        'petugas'          => Auth::user()->name,
                        'keterangan'       => "Adjustment stok opname {$stokOpname->nomor_opname}",
                    ]);
                }
            }
        });

        return redirect()->route('stok-opname.index')->with('success', 'Stok opname berhasil diselesaikan.');
    }
}
