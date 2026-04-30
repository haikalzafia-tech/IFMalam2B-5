@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Dasar halaman agar shadow menonjol */
    .page-inner {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Card Utama: 3D Soft Neumorphism */
    .main-card-3d {
        border: none !important;
        border-radius: 20px !important;
        background: #f8f9fa;
        box-shadow: 10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff !important;
        padding: 10px;
    }

    /* Wrapper untuk area Filter: Efek Cekung (Inset) */
    .filter-wrapper {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
    }

    /* Header Tabel */
    .custom-table thead th {
        background: transparent;
        border-bottom: 2px solid #eef0f2 !important;
        color: #495057;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 15px !important;
    }

    /* Baris Tabel */
    .custom-table tbody tr {
        transition: all 0.3s ease;
    }

   /* Pastikan baris tidak bergerak jika mengganggu elemen di dalamnya */
.custom-table tbody tr:hover {
    background: #ffffff !important;
    /* Hilangkan atau kurangi translateY jika menyebabkan flickering */
    transform: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

    .custom-table td {
        padding: 18px 15px !important;
        vertical-align: middle !important;
        border: none !important;
    }

    /* Nomor Urut */
    .badge-number {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 8px;
        box-shadow: 3px 3px 6px #d1d9e6, -3px -3px 6px #ffffff;
        font-weight: bold;
        color: #1a73e8;
    }

    /* Link Nama Produk */
    .product-link {
        color: #1a73e8;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .product-link:hover {
        color: #0d47a1;
        text-decoration: underline;
    }

    /* Badge Kategori */
    .category-label {
        background: #eef0f2;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    /* Responsivitas HP */
    @media (max-width: 768px) {
        .filter-wrapper .row > div {
            margin-bottom: 12px;
        }
        .page-inner { padding: 10px !important; }
        .main-card-3d { border-radius: 15px !important; }
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="card main-card-3d">
            <div class="card-body">



                <div class="filter-wrapper">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-9">
                            <div class="row g-2">
                                <div class="col-4 col-md-2">
                                    <x-per-page-option />
                                </div>
                                <div class="col-6 col-md-9">
                                    <x-filter-by-field term="search" placeholder="Cari nama produk..." />
                                </div>
                                <div class="col-2 col-md-1">
                                    <x-button-reset-filter route="master-data.produk.index" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-md-end text-center mt-3 mt-md-0">
                            <x-produk.form-produk />
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px">NO</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th class="text-center" style="width: 150px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produk as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <div class="badge-number mx-auto">
                                        {{ $produk->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.produk.show', $item->id) }}" class="product-link">
                                        {{ $item->nama_produk }}
                                    </a>
                                </td>
                                <td>
                                    <span class="category-label">
                                        <i class="fas fa-tag me-1 small"></i>
                                        {{ $item->kategori?->nama_kategori ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <x-produk.form-produk id="{{ $item->id }}" />
                                        <x-confirm-delete id="{{ $item->id }}" route="master-data.produk.destroy" />
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-boxes fa-3x text-light mb-3"></i>
                                    <p class="text-muted">Data produk tidak tersedia</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <p class="text-muted small mb-3 mb-md-0">
                        Menampilkan {{ $produk->firstItem() }} sampai {{ $produk->lastItem() }} dari {{ $produk->total() }} produk
                    </p>
                    <div>
                        {{ $produk->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
