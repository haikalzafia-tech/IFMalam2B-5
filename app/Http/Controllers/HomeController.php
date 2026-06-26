<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Rak;
use App\Models\Transaksi;
use App\Models\TransaksiRetur;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. Ringkasan Data Utama
        $totalProduk = Produk::count();
        $stokMenipis = VarianProduk::whereHas('produk', function ($q) {
            $q->whereColumn('stok_minimum', '>', 'varian_produks.stok_varian');
        })->count();

        // Total masuk/keluar termasuk retur (retur_masuk = nambah ke gudang, retur_keluar = ngurang dari gudang)
        $totalMasuk  = Transaksi::where('jenis_transaksi', 'pemasukan')->count()
            + TransaksiRetur::where('jenis_retur', 'retur_masuk')->count();
        $totalKeluar = Transaksi::where('jenis_transaksi', 'pengeluaran')->count()
            + TransaksiRetur::where('jenis_retur', 'retur_keluar')->count();

        // 2. Kapasitas Gudang — dihitung dari kapasitas_terpakai rak (sumber ini disinkronkan
        // setiap ada perubahan stok varian, baik dari transaksi maupun input manual)
        $totalKapasitas = Rak::sum('kapasitas_total');
        $totalTerpakai  = Rak::sum('kapasitas_terpakai');
        $persentaseKapasitas = $totalKapasitas > 0 ? round(($totalTerpakai / $totalKapasitas) * 100, 1) : 0;

        $gudangs = Gudang::withCount('zonas')->where('status', 'aktif')->get()->map(function ($g) {
            $kapasitasTotal = $g->raks()->sum('kapasitas_total');
            $kapasitasTerpakai = $g->raks()->sum('kapasitas_terpakai');
            $g->persentase = $kapasitasTotal > 0 ? round(($kapasitasTerpakai / $kapasitasTotal) * 100, 1) : 0;
            return $g;
        });

        // 3. Logika Pie Chart: distribusi barang per kategori
        $categories = DB::table('kategori_produks')
            ->leftJoin('produks', 'kategori_produks.id', '=', 'produks.kategori_produk_id')
            ->select('kategori_produks.nama_kategori', DB::raw('count(produks.id) as total'))
            ->groupBy('kategori_produks.id', 'kategori_produks.nama_kategori')
            ->get();

        $catLabels = $categories->pluck('nama_kategori');
        $catValues = $categories->pluck('total');

        // 4. Tren Transaksi 7 Hari Terakhir (termasuk retur)
        $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));
        $labels = $days->toArray();
        $dataMasuk = [];
        $dataKeluar = [];

        foreach ($labels as $date) {
            $masukHariIni = Transaksi::where('jenis_transaksi', 'pemasukan')->whereDate('created_at', $date)->count()
                + TransaksiRetur::where('jenis_retur', 'retur_masuk')->whereDate('created_at', $date)->count();

            $keluarHariIni = Transaksi::where('jenis_transaksi', 'pengeluaran')->whereDate('created_at', $date)->count()
                + TransaksiRetur::where('jenis_retur', 'retur_keluar')->whereDate('created_at', $date)->count();

            $dataMasuk[]  = $masukHariIni;
            $dataKeluar[] = $keluarHariIni;
        }

        // 5. Transaksi Terbaru (gabung masuk & keluar)
        $transaksiTerbaru = Transaksi::with('gudang', 'supplier')->latest()->take(5)->get();

        // 6. Barang dengan stok di bawah minimum (untuk tabel alert)
        $barangStokMenipis = VarianProduk::with('produk', 'rak.zona.gudang')
            ->whereHas('produk', function ($q) {
                $q->whereColumn('stok_minimum', '>', 'varian_produks.stok_varian');
            })
            ->take(5)
            ->get();

        return view('home', compact(
            'totalProduk', 'stokMenipis', 'totalMasuk', 'totalKeluar',
            'transaksiTerbaru', 'labels', 'dataMasuk', 'dataKeluar',
            'catLabels', 'catValues',
            'totalKapasitas', 'totalTerpakai', 'persentaseKapasitas', 'gudangs',
            'barangStokMenipis'
        ));
    }
}
