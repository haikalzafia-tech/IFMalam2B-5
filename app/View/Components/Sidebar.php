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
            // ===================== DASHBOARD =====================
            [
                'label'       => 'Dashboard Analitik',
                'route'       => 'home',
                'is_active'   => request()->routeIs('home'),
                'icon'        => 'fas fa-chart-line',
                'is_dropdown' => false,
            ],

            // ===================== MASTER DATA =====================
            [
                'label'       => 'Master Data',
                'route'       => '#',
                'is_active'   => request()->routeIs('master-data.*'),
                'icon'        => 'fas fa-database',
                'is_dropdown' => true,
                'items'       => [
                    ['label' => 'Kategori Barang',  'route' => 'master-data.kategori-produk.index'],
                    ['label' => 'Data Barang',       'route' => 'master-data.produk.index'],
                    ['label' => 'Data Supplier',     'route' => 'master-data.supplier.index'],
                ],
            ],

            // ===================== MANAJEMEN GUDANG =====================
            [
                'label'       => 'Manajemen Gudang',
                'route'       => '#',
                'is_active'   => request()->routeIs('master-data.gudang.*')
                                || request()->routeIs('master-data.zona.*')
                                || request()->routeIs('master-data.rak.*')
                                || request()->routeIs('lokasi-stok.*'),
                'icon'        => 'fas fa-warehouse',
                'is_dropdown' => true,
                'items'       => [
                    ['label' => 'Data Gudang', 'route' => 'master-data.gudang.index'],
                    ['label' => 'Data Zona',   'route' => 'master-data.zona.index'],
                    ['label' => 'Data Rak',    'route' => 'master-data.rak.index'],
                    ['label' => 'Lokasi Stok Barang', 'route' => 'lokasi-stok.index'],
                ],
            ],

            // ===================== TRANSAKSI =====================
            [
                'label'       => 'Transaksi Masuk',
                'route'       => '#',
                'is_active'   => request()->routeIs('transaksi-masuk.*'),
                'icon'        => 'fas fa-truck-loading',
                'is_dropdown' => true,
                'items'       => [
                    ['label' => 'Transaksi Baru',  'route' => 'transaksi-masuk.create', 'only_admin' => true],
                    ['label' => 'Data Transaksi',  'route' => 'transaksi-masuk.index'],
                ],
            ],
            [
                'label'       => 'Transaksi Keluar',
                'route'       => '#',
                'is_active'   => request()->routeIs('transaksi-keluar.*'),
                'icon'        => 'fas fa-dolly',
                'is_dropdown' => true,
                'items'       => [
                    ['label' => 'Transaksi Baru',  'route' => 'transaksi-keluar.create', 'only_admin' => true],
                    ['label' => 'Data Transaksi',  'route' => 'transaksi-keluar.index'],
                ],
            ],
            [
                'label'       => 'Transaksi Retur',
                'route'       => '#',
                'is_active'   => request()->routeIs('transaksi-retur.*'),
                'icon'        => 'fas fa-exchange-alt',
                'is_dropdown' => true,
                'items'       => [
                    ['label' => 'Retur Baru',     'route' => 'transaksi-retur.create', 'only_admin' => true],
                    ['label' => 'Data Retur',     'route' => 'transaksi-retur.index'],
                ],
            ],

            // ===================== STOK =====================
            [
                'label'       => 'Kartu Stok',
                'route'       => 'kartu-stok.index',
                'is_active'   => request()->routeIs('kartu-stok.*'),
                'icon'        => 'fas fa-clipboard-list',
                'is_dropdown' => false,
            ],
            [
                'label'       => 'Kelebihan Kapasitas',
                'route'       => 'kelebihan-kapasitas.index',
                'is_active'   => request()->routeIs('kelebihan-kapasitas.*'),
                'icon'        => 'fas fa-exclamation-triangle',
                'is_dropdown' => false,
                'badge'       => \App\Models\KelebihanKapasitas::where('status', 'menunggu')->count() ?: null,
            ],
            [
                'label'       => 'Stok Opname',
                'route'       => '#',
                'is_active'   => request()->routeIs('stok-opname.*'),
                'icon'        => 'fas fa-tasks',
                'is_dropdown' => true,
                'items'       => [
                    ['label' => 'Buat Opname Baru', 'route' => 'stok-opname.create', 'only_admin' => true],
                    ['label' => 'Data Opname',      'route' => 'stok-opname.index'],
                ],
            ],
            [
                'label'       => 'Export Laporan',
                'route'       => 'export-laporan.index',
                'is_active'   => request()->routeIs('export-laporan.*'),
                'icon'        => 'fas fa-file-excel',
                'is_dropdown' => false,
            ],

            // ===================== ADMIN ONLY =====================
            [
                'label'        => 'Kelola Akun Admin',
                'route'        => 'users.index',
                'is_active'    => request()->routeIs('users.*'),
                'icon'         => 'fas fa-user-cog',
                'is_dropdown'  => false,
                'only_manager' => true,
            ],
        ];

        $this->links = $this->filterLinks($allLinks);
    }

    private function filterLinks($links): array
    {
        $filtered = [];

        foreach ($links as $link) {
            if (isset($link['only_manager']) && Gate::denies('isManager')) {
                continue;
            }

            if (isset($link['items'])) {
                $link['items'] = array_values(array_filter($link['items'], function ($item) {
                    if (isset($item['only_admin']) && Gate::denies('isAdmin')) {
                        return false;
                    }
                    return true;
                }));
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
