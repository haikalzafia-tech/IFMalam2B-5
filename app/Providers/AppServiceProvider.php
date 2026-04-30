<?php

namespace App\Providers;

use App\Models\User; // Wajib di-import
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate; // Wajib di-import
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // 1. Gate untuk Admin (Akses Penuh)
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        // 2. Gate untuk Manager (Lihat & Buat Akun)
        Gate::define('isManager', function (User $user) {
            return $user->role === 'manager';
        });
    }
}
