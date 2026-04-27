<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeKategoriProdukRequest;
use App\Http\Requests\updateKategoriProdukRequest;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    public $pageTitle = 'Kategori Produk';
    public function index()
    {
        $pageTitle = $this->pageTitle;
        $parPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $query = KategoriProduk::query();

if ($search){
    $query->where('nama_kategori', 'like', '%'. $search . '%');
}

        $kategori = $query->paginate($parPage)->appends(request()->query());
        confirmDelete('Tidak dapat menghapus kategori produk sebelum menghapus data produk');
        return view('kategori-produk.index', compact('pageTitle','kategori'));
    }

    public function store(storeKategoriProdukRequest $request)
    {
        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        toast()->success('Kategori Produk Berhasil Ditambahkan');
        return redirect()->route('master-data.kategori-produk.index');
    }

    // Ubah $kategoriProduk menjadi $kategori_produk
    public function destroy(KategoriProduk $kategori_produk)
    {
        $kategori_produk->delete();
        toast()->success('Kategori produk berhasil dihapus');
        return redirect()->route('master-data.kategori-produk.index');
    }

    // Lakukan hal yang sama untuk fungsi update
    public function update(updateKategoriProdukRequest $request, KategoriProduk $kategori_produk)
    {
        $kategori_produk->nama_kategori = $request->nama_kategori;
        $kategori_produk->save();
        toast()->success('Kategori Produk Berhasil diubah');
        return redirect()->route('master-data.kategori-produk.index');
    }
}
