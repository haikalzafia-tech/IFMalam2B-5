<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiReturController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VarianProdukController;
use App\Http\Controllers\ZonaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiStokController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportHubController;
use App\Http\Controllers\KelebihanKapasitasController;

// ===================== PUBLIC =====================
Route::get('/', [LandingController::class, 'index'])->name('landing');

Auth::routes();

// ===================== AUTHENTICATED =====================
Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // ===================== MASTER DATA =====================
    Route::prefix('master-data')->name('master-data.')->group(function () {

        // Kategori Produk
        Route::resource('kategori-produk', KategoriProdukController::class);

        // Produk & Varian
        Route::resource('produk', ProdukController::class);
        Route::resource('varian-produk', VarianProdukController::class)->only(['store', 'update', 'destroy']);

        // Supplier
        Route::resource('supplier', SupplierController::class);
        Route::get('get-supplier', [SupplierController::class, 'getSupplierJson'])->name('supplier.json');

        // Gudang
        Route::resource('gudang', GudangController::class);

        // Zona
        Route::resource('zona', ZonaController::class)->except(['show']);

        // Rak
        Route::resource('rak', RakController::class);
        Route::get('get-rak-by-zona', [RakController::class, 'getRakByZona'])->name('rak.by-zona');
        Route::get('get-rak-by-gudang', [RakController::class, 'getRakByGudang'])->name('rak.by-gudang');
    });

    // ===================== TRANSAKSI =====================

    // Transaksi Masuk
    Route::prefix('transaksi-masuk')->name('transaksi-masuk.')->group(function () {
        Route::get('/', [TransaksiController::class, 'indexMasuk'])->name('index');
        Route::get('/create', [TransaksiController::class, 'createMasuk'])->name('create');
        Route::post('/', [TransaksiController::class, 'storeMasuk'])->name('store');
        Route::get('/{transaksi}', [TransaksiController::class, 'showMasuk'])->name('show');
    });

    // Transaksi Keluar
    Route::prefix('transaksi-keluar')->name('transaksi-keluar.')->group(function () {
        Route::get('/', [TransaksiController::class, 'indexKeluar'])->name('index');
        Route::get('/create', [TransaksiController::class, 'createKeluar'])->name('create');
        Route::post('/', [TransaksiController::class, 'storeKeluar'])->name('store');
        Route::get('/{transaksi}', [TransaksiController::class, 'showKeluar'])->name('show');
    });

    // ===================== LOKASI STOK (multi-rak per varian) =====================
    Route::prefix('lokasi-stok')->name('lokasi-stok.')->group(function () {
        Route::get('/', [LokasiStokController::class, 'index'])->name('index');
        Route::get('/{varianProduk}/edit', [LokasiStokController::class, 'edit'])->name('edit');
        Route::put('/{varianProduk}', [LokasiStokController::class, 'update'])->name('update');
    });

    // Transaksi Retur
    Route::resource('transaksi-retur', TransaksiReturController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('get-items-transaksi/{transaksi}', [TransaksiReturController::class, 'getItemsByTransaksi'])->name('get-items-transaksi');

  // ===================== KELEBIHAN KAPASITAS =====================
    Route::prefix('kelebihan-kapasitas')->name('kelebihan-kapasitas.')->group(function () {
        Route::get('/', [KelebihanKapasitasController::class, 'index'])->name('index');

        // PENTING: nama parameter {kelebihanKapasitas} harus SAMA PERSIS dengan
        // nama variabel di method controller, contoh:
        // public function getOpsiRak(KelebihanKapasitas $kelebihanKapasitas)
        // Kalau beda nama (misal {id}), Laravel gagal auto-resolve dari database.
        Route::get('/{kelebihanKapasitas}/opsi-rak', [KelebihanKapasitasController::class, 'getOpsiRak'])->name('opsi-rak');
        Route::post('/{kelebihanKapasitas}/pindah-rak', [KelebihanKapasitasController::class, 'pindahRak'])->name('pindah-rak');
        Route::post('/{kelebihanKapasitas}/retur', [KelebihanKapasitasController::class, 'returKelebihan'])->name('retur');
    });
    // ===================== STOK =====================
    Route::get('/kartu-stok', [KartuStokController::class, 'index'])->name('kartu-stok.index');
    Route::get('/kartu-stok/{nomor_sku}', [KartuStokController::class, 'show'])->name('kartu-stok.show');

    Route::resource('stok-opname', StokOpnameController::class)->only(['index', 'create', 'store', 'show', 'update']);

    // ===================== EXPORT EXCEL =====================
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/produk', [ExportController::class, 'produk'])->name('produk');
        Route::get('/transaksi-masuk', [ExportController::class, 'transaksiMasuk'])->name('transaksi-masuk');
        Route::get('/transaksi-keluar', [ExportController::class, 'transaksiKeluar'])->name('transaksi-keluar');
        Route::get('/transaksi-retur', [ExportController::class, 'transaksiRetur'])->name('transaksi-retur');
        Route::get('/kartu-stok', [ExportController::class, 'kartuStok'])->name('kartu-stok');
        Route::get('/supplier', [ExportController::class, 'supplier'])->name('supplier');
        Route::get('/rak', [ExportController::class, 'rak'])->name('rak');
    });

    // ===================== HALAMAN EXPORT LAPORAN TERPUSAT =====================
    Route::get('/export-laporan', [ExportHubController::class, 'index'])->name('export-laporan.index');

    // ===================== ADMIN ONLY =====================
    Route::middleware('can:isManager')->group(function () {
        Route::get('/kelola-admin', [UserController::class, 'index'])->name('users.index');
        Route::post('/kelola-admin', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});