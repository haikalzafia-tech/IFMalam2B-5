@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    .page-inner {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Card Utama - Statis & Solid */
    .main-card-3d {
        border: none !important;
        border-radius: 25px !important;
        background: #f8f9fa;
        box-shadow: 12px 12px 24px #d1d9e6, -12px -12px 24px #ffffff !important;
        overflow: hidden;
    }

    /* Area Filter - Efek Inset (Cekung) */
    .filter-panel {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
    }

    /* Input Styling */
    .form-control-3d {
        border-radius: 12px !important;
        border: 1px solid #e0e0e0 !important;
        background: #f8f9fa !important;
        padding: 10px 15px !important;
        height: 45px;
        transition: all 0.3s ease;
    }
    .form-control-3d:focus {
        box-shadow: 0 0 10px rgba(26, 115, 232, 0.2) !important;
        background: #ffffff !important;
        border-color: #1a73e8 !important;
    }

    /* Tombol Cari - Blue Glow 3D */
    .btn-search-3d {
        background: linear-gradient(135deg, #1d7af3 0%, #0d47a1 100%);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(29, 122, 243, 0.4);
        transition: all 0.2s ease;
        height: 45px;
        width: 100%;
    }
    .btn-search-3d:hover {
        box-shadow: 0 6px 20px rgba(29, 122, 243, 0.6);
        filter: brightness(1.1);
        color: white;
    }
    .btn-search-3d:active {
        transform: scale(0.96);
        box-shadow: inset 4px 4px 10px rgba(0,0,0,0.2);
    }

    /* Tombol Reset - Clean Glass Red */
    .btn-reset-3d {
        background: #ffffff;
        border: 2px solid #f25961;
        color: #f25961;
        font-weight: 700;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        height: 45px;
        width: 100%;
        box-shadow: 4px 4px 10px #d1d9e6;
        text-decoration: none;
    }
    .btn-reset-3d:hover {
        background: #f25961;
        color: white;
        box-shadow: 0 4px 12px rgba(242, 89, 97, 0.3);
    }
    .btn-reset-3d:active {
        transform: scale(0.96);
    }

    /* Tabel - Teks Lurus & Rapih */
    .table-3d th, .table-3d td {
        white-space: nowrap; /* Tulisan tetap lurus satu baris */
        padding: 18px 20px !important;
        vertical-align: middle !important;
        border: none !important;
    }

    .table-3d thead th {
        background: transparent;
        border-bottom: 2px solid #dee2e6 !important;
        color: #495057;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .table-3d tbody tr:hover {
        background: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Label Minimalist */
    .filter-label-minimal {
        font-size: 11px;
        font-weight: 800;
        color: #adb5bd;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        display: block;
    }

    /* Badge Nomor Transaksi */
    .trx-number {
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: bold;
        color: #1a73e8;
        padding: 5px 10px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 2px 2px 5px #d1d9e6;
    }

    .badge-number {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        background: #f8f9fa; border-radius: 8px;
        box-shadow: 3px 3px 6px #d1d9e6, -3px -3px 6px #ffffff;
        font-weight: bold; color: #1a73e8;
    }
</style>

<div class="container-fluid">
    <div class="page-inner py-4">
        <div class="card main-card-3d">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div style="width: 4px; height: 24px; background: #1a73e8; border-radius: 10px; margin-right: 12px;"></div>
                        <h4 class="fw-bold m-0 text-dark">Riwayat Transaksi Masuk</h4>
                    </div>
                    <x-form-export-laporan jenisTransaksi="pemasukan" />
                </div>

                <div class="filter-panel">
                    <form action="{{ route('transaksi-masuk.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="filter-label-minimal ms-1">PENGIRIM</label>
                            <input type="text" name="pengirim" class="form-control form-control-3d"
                                placeholder="Nama Pengirim..." value="{{ request('pengirim') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="filter-label-minimal ms-1">TANGGAL AWAL</label>
                            <input type="date" name="tanggal_awal" class="form-control form-control-3d"
                                value="{{ request('tanggal_awal') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="filter-label-minimal ms-1">TANGGAL AKHIR</label>
                            <input type="date" name="tanggal_akhir" class="form-control form-control-3d"
                                value="{{ request('tanggal_akhir') }}">
                        </div>

                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <div class="flex-fill">
                                    <label class="filter-label-minimal">&nbsp;</label>
                                    <button type="submit" class="btn-search-3d">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                                <div class="flex-fill">
                                    <label class="filter-label-minimal">&nbsp;</label>
                                    <a href="{{ route('transaksi-masuk.index') }}" class="btn-reset-3d">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-3d">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>Nomor Transaksi</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                                <th>Pengirim</th>
                                <th>Tanggal Transaksi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksi as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <div class="badge-number mx-auto">{{ $index + 1 }}</div>
                                </td>
                                <td><span class="trx-number">{{ $item->nomor_transaksi }}</span></td>
                                <td>
                                    <span class="fw-bold text-dark">{{ number_format($item->jumlah_barang) }}</span>
                                    <small class="text-muted">unit</small>
                                </td>
                                <td><span class="text-success fw-bold">Rp {{ number_format($item->total_harga) }}</span></td>
                                <td>{{ $item->pengirim }}</td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('transaksi-masuk.show', $item->nomor_transaksi) }}"
                                        class="btn btn-sm btn-round btn-dark px-3 shadow-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada riwayat transaksi masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transaksi->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
