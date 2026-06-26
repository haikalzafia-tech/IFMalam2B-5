<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{

    public function index(Request $request)
    {
        $perPage = 10;

        $kategori = KategoriProduk::withCount('produks')
            ->when($request->search, fn($q) => $q->where('nama_kategori', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $pageTitle = 'Kategori Barang';

        return view('kategori-produk.index', compact('kategori', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_produks,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        KategoriProduk::create([
            'kode_kategori' => $this->generateKode(),
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('master-data.kategori-produk.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriProduk $kategoriProduk)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_produks,nama_kategori,' . $kategoriProduk->id,
            'deskripsi'     => 'nullable|string',
        ]);

        $kategoriProduk->update($request->only(['nama_kategori', 'deskripsi']));

        return redirect()->route('master-data.kategori-produk.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriProduk $kategoriProduk)
    {
        if ($kategoriProduk->produks()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh barang.');
        }

        $kategoriProduk->delete();

        return redirect()->route('master-data.kategori-produk.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function generateKode(): string
    {
        $last = KategoriProduk::latest()->first();
        $num = $last ? (int) substr($last->kode_kategori, 4) + 1 : 1;
        return 'KTG-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
