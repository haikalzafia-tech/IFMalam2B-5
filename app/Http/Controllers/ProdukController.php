<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\updateProdukRequest;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // OOP Property (Encapsulation): Judul halaman yang dibungkus dalam properti class
    public $pageTitle = 'Data barang';

    // [R] - READ: Menampilkan daftar produk dengan relasi, pencarian, dan paginasi
    public function index()
    {
        $query = Produk::query();
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $pageTitle = $this->pageTitle;

        // Mengambil data kategori untuk dikirim ke modal "Tambah Produk"
        $kategori = KategoriProduk::all();

        // OOP Association (Eager Loading): Mengambil data produk beserta kategori relasinya
        $query->with('kategori:id,nama_kategori');

        // Fitur Pencarian Data
        if($search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        }

        $produk = $query->orderBy('created_at','DESC')->paginate($perPage)->appends(request()->query());

        // Integrasi SweetAlert OOP Component untuk konfirmasi hapus data
        confirmDelete('Menghapus data produk akan menghapus semua varian yang ada, lanjutkan?');

        return view('produk.index', compact('pageTitle', 'produk', 'kategori'));
    }

    // [C] - CREATE: Menyimpan produk baru setelah lolos validasi OOP Form Request
    public function store(StoreProdukRequest $request)
    {
        $Produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'kategori_produk_id' => $request->kategori_produk_id
        ]);

        toast()->success('Produk berhasil ditambahkan');
        return redirect()->route('master-data.produk.show', $Produk->id);
    }

    // [U] - UPDATE: Memperbarui data menggunakan Dependency Injection (Produk $produk)
    public function update(updateProdukRequest $request, Produk $produk){
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'kategori_produk_id' => $request->kategori_produk_id
        ]);
        toast()->success('Produk berhasil diubah');
        return redirect()->route('master-data.produk.index');
    }

    // [R] - READ DETAIL: Menampilkan spesifikasi tunggal produk
    public function show(Produk $produk)
    {
        $pageTitle = $this->pageTitle;
        return view('produk.show', compact('produk', 'pageTitle'));
    }

    // [D] - DELETE: Menghapus produk menggunakan rute model binding
    public function destroy(Produk $produk){
        $produk->delete();
        toast()->success('Produk berhasil dihapus');
        return redirect()->route('master-data.produk.index');
    }
}
