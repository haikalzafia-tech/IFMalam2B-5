@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Dasar halaman dengan warna soft agar shadow menonjol */
    .page-inner {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Card Utama: 3D Soft Neumorphism */
    .main-card-3d {
        border: none !important;
        border-radius: 20px !important;
        background: #f8f9fa;
        /* Shadow luar untuk efek timbul */
        box-shadow: 10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff !important;
        padding: 10px;
    }

    /* Wrapper untuk area Filter: Efek Cekung (Inset) */
    .filter-wrapper {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        /* Shadow dalam agar terlihat masuk ke dalam permukaan */
        box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
    }

    /* Header Tabel yang bersih */
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

    /* Baris Tabel yang melayang saat di-hover */
    .custom-table tbody tr {
        transition: all 0.3s ease;
    }

    .custom-table tbody tr:hover {
        background: #ffffff !important;
        /* Efek mengangkat baris */
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .custom-table td {
        padding: 18px 15px !important;
        vertical-align: middle !important;
        border: none !important;
    }

    /* Nomor Urut Bulat */
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

    /* Button Styling */
    .action-btn-wrapper {
        display: flex;
        gap: 8px;
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
                                    <x-filter-by-field term='search' placeholder="Cari kategori produk..." />
                                </div>
                                <div class="col-2 col-md-1">
                                    <x-button-reset-filter route="master-data.kategori-produk.index" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-md-end text-center mt-3 mt-md-0">
                            <x-kategori-produk.form-kategori-produk />
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px">No</th>
                                <th>Nama Kategori</th>
                                <th class="text-center" style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <div class="badge-number mx-auto">
                                        {{ $kategori->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 15px;">{{ $item->nama_kategori }}</span>
                                </td>
                                <td>
                                    <div class="action-btn-wrapper justify-content-center">
                                        <x-kategori-produk.form-kategori-produk id="{{ $item->id }}" />
                                        <x-confirm-delete id="{{ $item->id }}" route="master-data.kategori-produk.destroy" />
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                                    <p class="text-muted">Data kategori belum tersedia</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <p class="text-muted small mb-3 mb-md-0">
                        Menampilkan {{ $kategori->firstItem() }} sampai {{ $kategori->lastItem() }} dari {{ $kategori->total() }} data
                    </p>
                    <div class="pagination-3d">
                        {{ $kategori->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
