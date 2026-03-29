<?php

use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan baris ini!

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//master-data/kategori-produk/create
//master-data.kategori-produk.index

Route::middleware('auth')->group(function(){
    Route::prefix('master-data')->name('master-data.')->group(function(){
        Route::resource('kategori-produk', KategoriProdukController::class);
        Route::resource('produk', ProdukController::class);
    });
});