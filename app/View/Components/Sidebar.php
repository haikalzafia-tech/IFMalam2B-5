<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;

class Sidebar extends Component
{
    public $links;

    public function __construct()
    {
        $allLinks = [
            [
                'label' => 'Dasboard Analitik',
                'route' => 'home',
                'is_active' => request()->routeIs('home'),
                'icon' => 'fas fa-chart-line',
                'is_dropdown' => false
            ],
            [
                'label' => 'Master Data',
                'route' => '#',
                'is_active' => request()->routeIs('master-data.*'),
                'icon' => 'fas fa-cloud',
                'is_dropdown' => true,
                'items' => [
                    ['label' => 'Kategori Barang', 'route' => 'master-data.kategori-produk.index'],
                    ['label' => 'Data Barang', 'route' => 'master-data.produk.index'],
                    ['label' => 'Stok Barang', 'route' => 'master-data.stok-barang.index'],
                ]
            ],
            [
                'label' => 'Transaksi Masuk',
                'route' => '#',
                'is_active' => request()->routeIs('transaksi-masuk.*'),
                'icon' => 'fas fa-truck-loading',
                'is_dropdown' => true,
                'items' => [
                    ['label' => 'Transaksi Baru', 'route' => 'transaksi-masuk.create', 'only_admin' => true],
                    ['label' => 'Data Transaksi', 'route' => 'transaksi-masuk.index'],
                ]
            ],
            [
                'label' => 'Transaksi Keluar',
                'route' => '#',
                'is_active' => request()->routeIs('transaksi-keluar.*'),
                'icon' => 'fas fa-dollar-sign',
                'is_dropdown' => true,
                'items' => [
                    ['label' => 'Transaksi Baru', 'route' => 'transaksi-keluar.create', 'only_admin' => true],
                    ['label' => 'Data Transaksi', 'route' => 'transaksi-keluar.index'],
                ]
            ],
            [
                'label' => 'Transaksi Retur',
                'route' => '#',
                'is_active' => request()->routeIs('transaksi-retur.*'),
                'icon' => 'fas fa-exchange-alt',
                'is_dropdown' => true,
                'items' => [
                    ['label' => 'Transaksi Baru', 'route' => 'transaksi-retur.create', 'only_admin' => true],
                    ['label' => 'Data Transaksi', 'route' => 'transaksi-retur.index'],
                ]
            ],
            [
                'label' => 'Laporan Kenaikan Harga',
                'route' => 'laporan-kenaikan-harga.index',
                'is_active' => request()->routeIs('laporan-kenaikan-harga.*'),
                'icon' => 'fas fa-level-up-alt',
                'is_dropdown' => false
            ],
            // MENU KHUSUS MANAGER: Membuat akun Admin
            [
                'label' => 'Kelola Akun Admin',
                'route' => 'users.index', // Pastikan route ini ada
                'is_active' => request()->routeIs('users.*'),
                'icon' => 'fas fa-user-cog',
                'is_dropdown' => false,
                'only_manager' => true
            ],
        ];

        $this->links = $this->filterLinks($allLinks);
    }

    /**
     * Fungsi untuk menyaring menu berdasarkan Role
     */
    private function filterLinks($links)
    {
        $filtered = [];

        foreach ($links as $link) {
            // 1. Cek jika menu utama hanya untuk Manager
            if (isset($link['only_manager']) && Gate::denies('isManager')) {
                continue;
            }

            // 2. Jika punya sub-menu (dropdown), filter item di dalamnya
            if (isset($link['items'])) {
                $link['items'] = array_filter($link['items'], function ($item) {
                    // Jika item ada tanda 'only_admin', maka Manager tidak bisa lihat
                    if (isset($item['only_admin']) && Gate::denies('isAdmin')) {
                        return false;
                    }
                    return true;
                });
            }

            $filtered[] = $link;
        }

        return $filtered;
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
