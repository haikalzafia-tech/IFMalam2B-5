<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman landing utama SIGMA.
     * * @return View
     */
    public function index()
{
    return view('landing.index', [
        'pageTitle' => 'SIGMA - Sistem Gudang Manajemen'
    ]);
    // Mengambil data hero dari database
    $hero = \App\Models\Landing::where('section_key', 'hero_main')->first();

    // Mengambil semua data fitur dari database
    // Pastikan Anda sudah menjalankan php artisan db:seed
    $features = \App\Models\Landing::where('section_key', 'like', 'feature_%')
                                    ->where('is_visible', true)
                                    ->get();

    return view('landing.index', compact('hero', 'features'));
}
}
