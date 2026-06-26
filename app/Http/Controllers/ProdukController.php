<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Rak;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index(Request $request)
    {
        $perPage = 10;

        $produk = Produk::with('kategoriProduk', 'varianProduks')
            ->when($request->search, fn($q) => $q->where('nama_produk', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $pageTitle = 'Data Barang';

        return view('produk.index', compact('produk', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_produk_id' => 'nullable|exists:kategori_produks,id',
            'nama_produk'        => 'required|string|max:255',
            'merek'              => 'nullable|string|max:255',
            'satuan'             => 'required|string|max:50',
            'stok_minimum'       => 'required|integer|min:0',
            'deskripsi_produk'   => 'nullable|string',
        ]);

        $data = $request->all();
        $data['kode_produk'] = $this->generateKodeProduk();

        Produk::create($data);

        return redirect()->route('master-data.produk.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        $produk->load('kategoriProduk', 'varianProduks.rak.zona.gudang');
        $pageTitle = 'Detail Barang';

        // Untuk dropdown rak di form tambah/edit varian
        $raks = Rak::with('zona.gudang')->where('status', '!=', 'nonaktif')->get();

        return view('produk.show', compact('produk', 'pageTitle', 'raks'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kategori_produk_id' => 'nullable|exists:kategori_produks,id',
            'nama_produk'        => 'required|string|max:255',
            'merek'              => 'nullable|string|max:255',
            'satuan'             => 'required|string|max:50',
            'stok_minimum'       => 'required|integer|min:0',
            'deskripsi_produk'   => 'nullable|string',
        ]);

        $produk->update($request->all());

        return redirect()->route('master-data.produk.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->varianProduks()->exists()) {
            return back()->with('error', 'Barang tidak bisa dihapus karena masih memiliki varian.');
        }

        $produk->delete();

        return redirect()->route('master-data.produk.index')->with('success', 'Barang berhasil dihapus.');
    }

    private function generateKodeProduk(): string
    {
        $last = Produk::latest()->first();
        $num = $last ? (int) substr($last->kode_produk, 4) + 1 : 1;
        return 'PRD-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
