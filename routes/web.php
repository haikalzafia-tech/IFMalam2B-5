<?php

use App\Http\Controllers\ExportLaporanTransaksiControler;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LaporanKenaikanHargaController;
use App\Http\Controllers\PeriodeStokOpnameController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TransaksiKeluarController;
use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\TransaksiReturController;
use App\Http\Controllers\VarianProdukController;
use App\Models\PeriodeStokOpname;
use Illuminate\Support\Facades\Auth; // Tambahkan baris ini!
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; // Pastikan controller ini ada

Route::middleware(['auth', 'can:isManager'])->group(function () {
    // Route untuk menampilkan daftar admin dan form buat admin
    Route::get('/kelola-admin', [UserController::class, 'index'])->name('users.index');
    Route::post('/kelola-admin', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});



// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/', [LandingController::class, 'index'])->name('landing');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//master-data/kategori-produk/create
//master-data.kategori-produk.index

Route::middleware('auth')->group(function() {

    Route::prefix('get-data')->name('get-data.')->group(function () {
        Route::get('/varian-produk', [VarianProdukController::class, 'getAllVarianJson'])->name('varian-produk');
        Route::get('/transaksi-keluar', [TransaksiKeluarController::class, 'getTransaksiKeluar'])->name('transaksi-keluar');
        Route::get('/transaksi-keluar/{nomor_transaksi}', [TransaksiKeluarController::class, 'getTransaksiKeluarItems'])->name('transaksi-keluar-items');
    });

    // URL-nya adalah '/profile', bukan '/profile.blade.php'
Route::get('/profile', function () {
    // Ini merujuk ke folder resources/views/auth/passwords/profile.blade.php
    return view('auth.passwords.profile');
})->name('profile.show');

    Route::post('export-laporan-transaksi', [ExportLaporanTransaksiControler::class, 'exportLaporanTransaksi'])->name('export-laporan-transaksi');

    Route::resource('laporan-kenaikan-harga', LaporanKenaikanHargaController::class)->only(['index', 'update']);


    Route::prefix('master-data')->name('master-data.')->group(function(){
        Route::resource('kategori-produk', KategoriProdukController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('varian-produk',VarianProdukController::class)->only(['store','update','destroy']);
        Route::resource('stok-barang', StokBarangController::class)->only(['index']);
    });

    Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

    Route::get('/kartu-stok/{nomor_sku}', [KartuStokController::class, 'kartuStok'])->name('kartu-stok');
    Route::resource('transaksi-masuk', TransaksiMasukController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('transaksi-keluar', TransaksiKeluarController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('transaksi-retur', TransaksiReturController::class)->only(['index', 'create', 'store', 'show']);
    Route::prefix('stok-opname')->name('stok-opname.')->group(function(){
    Route::resource('periode', PeriodeStokOpnameController::class);
    });
});