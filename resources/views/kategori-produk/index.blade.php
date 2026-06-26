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
        box-shadow: 10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff !important;
        padding: 10px;
    }

    .filter-wrapper {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
    }

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

    .custom-table tbody tr {
        transition: all 0.3s ease;
    }

    .custom-table tbody tr:hover {
        background: #ffffff !important;
        transform: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .custom-table td {
        padding: 18px 15px !important;
        vertical-align: middle !important;
        border: none !important;
    }

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

    .kode-pill {
        background: #eef0f2;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #6c757d;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    .jumlah-produk-pill {
        background: rgba(26, 115, 232, 0.08);
        color: #1a73e8;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .action-btn-wrapper {
        display: flex;
        gap: 8px;
    }

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
                                   {{-- <x-per-page-option /> --}}
                                </div>
                                <div class="col-6 col-md-9">
                                    <x-filter-by-field term='search' placeholder="Cari kategori barang..." />
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
                                <th class="text-center" style="width: 70px">No</th>
                                <th style="width: 130px">Kode</th>
                                <th>Nama Kategori</th>
                                <th class="text-center" style="width: 140px">Jumlah Barang</th>
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
                                <td><span class="kode-pill">{{ $item->kode_kategori }}</span></td>
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 15px;">{{ $item->nama_kategori }}</span>
                                    @if($item->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="jumlah-produk-pill">{{ $item->produks_count }} barang</span>
                                </td>
                                <td>
                                    <div class="action-btn-wrapper justify-content-center">
                                        <x-kategori-produk.form-kategori-produk
                                            id="{{ $item->id }}"
                                            nama_kategori="{{ $item->nama_kategori }}"
                                            deskripsi="{{ $item->deskripsi }}"
                                            action="{{ route('master-data.kategori-produk.update', $item->id) }}" />
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
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
