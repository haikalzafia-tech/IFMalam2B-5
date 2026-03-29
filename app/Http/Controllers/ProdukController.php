<?php

namespace App\Http\Controllers;

// PERBAIKAN: Pastikan mengimport Request yang benar (Gunakan Huruf Besar di awal/PascalCase)
use App\Http\Requests\StoreProdukRequest; 
use App\Http\Requests\updateProdukRequest;
use App\Models\Produk;
use App\Models\KategoriProduk; // Tambahkan ini jika ingin mengambil data kategori untuk modal
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public $pageTitle = 'Data produk';

    public function index()
    {
        $query = Produk::query();
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $pageTitle = $this->pageTitle;
        
        // Mengambil data kategori untuk dikirim ke modal "Tambah Produk"
        $kategori = KategoriProduk::all(); 
        
        $query->with('kategori:id,nama_kategori');
        
        if($search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        }

        $produk = $query->orderBy('created_at','DESC')->paginate($perPage)->appends(request()->query());
        
        // Pastikan library RealRashid SweetAlert sudah terpasang untuk confirmDelete
        confirmDelete('Menghapus data produk akan menghapus semua varian yang ada, lanjutkan?');
        
        // PERBAIKAN: Kirim variabel $kategori ke view agar looping di modal tidak error
        return view('produk.index', compact('pageTitle', 'produk'));
    }

    // PERBAIKAN: Nama Class di sini harus SAMA dengan yang di-import di atas
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

    public function update(updateProdukRequest $request, Produk $produk){
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'kategori_produk_id' => $request->kategori_produk_id
        ]);
        toast()->success('Produk berhasil diubah');
        return redirect()->route('master-data.produk.index');
    }

    public function show(Produk $produk)
    {
        $pageTitle = $this->pageTitle;
        return view('produk.show', compact('produk', 'pageTitle'));
        
    }
    
    public function destroy(Produk $produk){
        $produk->delete();
        toast()->success('Produk berhasil dihapus');
        return redirect()->route('master-data.produk.index');
    }
}