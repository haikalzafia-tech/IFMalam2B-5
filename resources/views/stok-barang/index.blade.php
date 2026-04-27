@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    .page-inner {
        background: #f8f9fa;
        min-height: 100vh;
    }

    .main-card-3d {
        border: none !important;
        border-radius: 20px !important;
        background: #f8f9fa;
        box-shadow: 12px 12px 24px #d1d9e6, -12px -12px 24px #ffffff !important;
    }

    .filter-wrapper {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
    }

    /* Paksa teks dalam tabel tetap lurus (satu baris) */
    .custom-table th,
    .custom-table td {
        white-space: nowrap; /* INI KUNCINYA: Tulisan tidak akan turun ke bawah */
        padding: 15px 20px !important;
        vertical-align: middle !important;
        border: none !important;
    }

    .custom-table thead th {
        background: transparent;
        border-bottom: 2px solid #dee2e6 !important;
        color: #495057;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
    }

    .custom-table tbody tr:hover {
        background: #ffffff !important;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    /* Memberikan lebar minimal agar tidak sesak saat lurus */
    .col-produk { min-width: 250px; }
    .col-sku { min-width: 120px; }
    .col-stok { min-width: 100px; }
    .col-harga { min-width: 150px; }

    .sku-code {
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: bold;
        color: #1a73e8;
        background: #ffffff;
        padding: 5px 10px;
        border-radius: 8px;
        box-shadow: 2px 2px 5px #d1d9e6;
    }

    .badge-number {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff;
        font-weight: bold;
        color: #1a73e8;
    }
</style>

<div class="container-fluid"> <div class="page-inner py-4">
        <div class="card main-card-3d">
            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">
                    <div style="width: 4px; height: 24px; background: #1a73e8; border-radius: 10px; margin-right: 12px;"></div>
                    <h4 class="fw-bold m-0">Laporan Stok Barang</h4>
                </div>

                <div class="filter-wrapper">
                    <div class="row align-items-center g-3">
                        <div class="col-md-10">
                            <div class="row g-2">
                                <div class="col-4 col-md-2">
                                    <x-per-page-option />
                                </div>
                                <div class="col-8 col-md-6">
                                    <x-filter-by-field term="search" placeholder="Cari SKU atau Produk..." />
                                </div>
                                <div class="col-12 col-md-4">
                                    <x-filter-by-options term="kategori" :options="$kategori" field="nama_kategori"
                                        defaultValue="Semua Kategori" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-md-end">
                            <x-button-reset-filter route="master-data.stok-barang.index" />
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px">No</th>
                                <th class="col-sku">SKU</th>
                                <th class="col-produk">Produk</th>
                                <th>Kategori</th>
                                <th class="col-stok text-end">Stok</th>
                                <th class="col-harga">Harga</th>
                                <th class="text-center">Kartu Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produk as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <div class="badge-number mx-auto">{{ $index + 1 }}</div>
                                </td>
                                <td><span class="sku-code">{{ $item['nomor_sku'] }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $item['produk'] }}</span></td>
                                <td>
                                    <span class="badge bg-white text-muted border shadow-sm px-3 py-2" style="border-radius: 15px;">
                                        {{ $item['kategori'] }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-dark" style="font-size: 1.1rem;">{{ number_format($item['stok']) }}</span>
                                    <small class="text-muted">unit</small>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">Rp {{ number_format($item['harga']) }}</span>
                                </td>
                                <td class="text-center">
                                    <x-kartu-stok nomor_sku="{{ $item['nomor_sku'] }}" />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $produk->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
