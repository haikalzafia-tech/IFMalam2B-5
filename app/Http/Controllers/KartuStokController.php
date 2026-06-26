<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\KartuStok;
use App\Models\VarianProduk;
use Illuminate\Http\Request;

class KartuStokController extends Controller
{

    public function index(Request $request)
    {
        $query = KartuStok::with(['varianProduk.produk', 'gudang', 'rak.zona']);

        if ($request->nomor_sku) {
            $query->whereHas('varianProduk', fn($q) => $q->where('nomor_sku', $request->nomor_sku));
        }

        if ($request->gudang_id) {
            $query->where('gudang_id', $request->gudang_id);
        }

        if ($request->jenis_transaksi) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        if ($request->dari && $request->sampai) {
            $query->whereBetween('created_at', [$request->dari, $request->sampai . ' 23:59:59']);
        }

        $kartuStoks = $query->latest()->paginate(10)->withQueryString();
        $gudangs    = Gudang::where('status', 'aktif')->get();
        $varianProduks = VarianProduk::with('produk')->get();

        return view('kartu-stok.index', compact('kartuStoks', 'gudangs', 'varianProduks'));
    }

    public function show(Request $request, string $nomorSku)
    {
        $varian = VarianProduk::with('produk', 'rak.zona.gudang')
            ->where('nomor_sku', $nomorSku)->firstOrFail();

        $kartuStoks = KartuStok::with('gudang', 'rak')
            ->where('varian_produk_id', $varian->id)
            ->latest()->paginate(10);

        return view('kartu-stok.show', compact('varian', 'kartuStoks'));
    }
}
