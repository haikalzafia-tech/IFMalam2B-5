<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeKategoriProdukRequest;
use App\Http\Requests\updateKategoriProdukRequest;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class KategoriProdukController extends Controller
{
    public $pageTitle = 'Kategori Produk';

    public function __construct()
    {
        // Middleware ini akan mencegat user non-admin sebelum masuk ke fungsi store, update, dan destroy
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Jika bukan admin, tendang balik atau kasih error 403
            abort(403, 'Akses Ditolak: Hanya Admin yang boleh memodifikasi Kategori Produk.');
        })->only(['store', 'update', 'destroy']);
        // Index tetap bisa dilihat semua orang (Staff/Admin)
    }

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

        // SweetAlert Confirm Delete
        confirmDelete('Hapus Kategori', 'Tidak dapat menghapus kategori produk sebelum menghapus data produk');

        return view('kategori-produk.index', compact('pageTitle','kategori'));
    }

    public function store(storeKategoriProdukRequest $request)
    {
        // Keamanan tambahan: Pastikan data yang masuk benar-benar nama_kategori
        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        toast()->success('Kategori Produk Berhasil Ditambahkan');
        return redirect()->route('master-data.kategori-produk.index');
    }

    public function update(updateKategoriProdukRequest $request, KategoriProduk $kategori_produk)
    {
        $kategori_produk->nama_kategori = $request->nama_kategori;
        $kategori_produk->save();

        toast()->success('Kategori Produk Berhasil diubah');
        return redirect()->route('master-data.kategori-produk.index');
    }

    public function destroy(KategoriProduk $kategori_produk)
    {
        $kategori_produk->delete();

        toast()->success('Kategori produk berhasil dihapus');
        return redirect()->route('master-data.kategori-produk.index');
    }
}
