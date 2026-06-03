<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Pastikan nama model kamu sesuai (Produk, VarianProduk, Transaksi, dll)
use App\Models\Produk;
use App\Models\VarianProduk;
use App\Models\Transaksi;
use App\Models\TransaksiRetur;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  public function index()
{
    // 1. Ringkasan Data Utama
    $totalProduk = \App\Models\Produk::count();
    $stokMenipis = \App\Models\VarianProduk::where('stok_varian', '<', 10)->count();
    $totalMasuk = \App\Models\Transaksi::where('jenis_transaksi', 'pemasukan')->count();
    $totalKeluar = \App\Models\Transaksi::where('jenis_transaksi', 'pengeluaran')->count();

   // --- LOGIKA UNTUK PIE CHART ---
$categories = \DB::table('kategori_produks')
    // Perhatikan bagian 'produks.kategori_produk_id' di bawah ini
    ->leftJoin('produks', 'kategori_produks.id', '=', 'produks.kategori_produk_id')
    ->select('kategori_produks.nama_kategori', \DB::raw('count(produks.id) as total'))
    ->groupBy('kategori_produks.id', 'kategori_produks.nama_kategori')
    ->get();

$catLabels = $categories->pluck('nama_kategori');
$catValues = $categories->pluck('total');



    // 3. Logika Tren Transaksi 7 Hari
    $days = collect(range(6, 0))->map(function($i) {
        return now()->subDays($i)->format('Y-m-d');
    });
    $labels = $days->toArray();
    $dataMasuk = [];
    $dataKeluar = [];

    foreach ($labels as $date) {
        $dataMasuk[] = \App\Models\Transaksi::where('jenis_transaksi', 'pemasukan')
                        ->whereDate('created_at', $date)->count();
        $dataKeluar[] = \App\Models\Transaksi::where('jenis_transaksi', 'pengeluaran')
                        ->whereDate('created_at', $date)->count();
    }

    $transaksiTerbaru = \App\Models\Transaksi::latest()->take(5)->get();

    // 4. Kirim Data ke View
    return view('home', compact(
        'totalProduk', 'stokMenipis', 'totalMasuk', 'totalKeluar',
        'transaksiTerbaru', 'labels', 'dataMasuk', 'dataKeluar',
        'catLabels', 'catValues'
    ));
}
}
