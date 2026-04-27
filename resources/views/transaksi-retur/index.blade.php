
@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Reset & Base */
    .page-inner { background: #f4f7fa; min-height: 100vh; padding: 2rem 1.5rem; }

    /* Modern Card */
    .sigma-container {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 1.5rem;
    }

    /* Header Section */
    .header-title { color: #1e293b; font-size: 1.25rem; font-weight: 800; letter-spacing: -0.5px; }
    .accent-bar { width: 35px; height: 5px; background: #f59e0b; border-radius: 10px; margin-bottom: 8px; }

    /* Filter Panel - Clean & Integrated */
    .filter-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        border: 1px solid #edf2f7;
    }
    .filter-label { font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }

    /* Input & Select Custom */
    .form-sigma {
        border-radius: 8px !important;
        border: 1.5px solid #e2e8f0 !important;
        background: #ffffff !important;
        font-weight: 500;
        color: #334155;
        transition: all 0.2s;
    }
    .form-sigma:focus { border-color: #f59e0b !important; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1) !important; }

    /* Table Typography */
    .table-sigma thead th {
        background: transparent;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        border-bottom: 2px solid #f1f5f9;
    }
    .table-sigma tbody td { padding: 1.25rem 1rem; vertical-align: middle; color: #334155; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }

    /* Code-style Badge */
    .badge-code {
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
        background: #fffbeb;
        color: #b45309;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #fef3c7;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Price Label */
    .price-text { font-weight: 700; color: #1e293b; }

    /* Empty State */
    .empty-state { padding: 4rem 0; color: #94a3b8; text-align: center; }
</style>

<div class="container-fluid">
    <div class="page-inner">
        <div class="sigma-container">

            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="accent-bar"></div>
                    <h1 class="header-title m-0">Data Retur Barang</h1>
                    <p class="text-muted small m-0">Kelola pengembalian barang dari pengirim/supplier</p>
                </div>
                <div class="d-flex gap-2">
                    </div>
            </div>

            <div class="filter-box">
                <form action="{{ route('transaksi-retur.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <span class="filter-label">Tampilkan</span>
                        <x-per-page-option class="form-sigma"/>
                    </div>
                    <div class="col-md-8">
                        <span class="filter-label">Pencarian Cepat</span>
                        <x-filter-by-field term="search" placeholder="Cari No. Retur, Transaksi, atau Pengirim..." class="form-sigma"/>
                    </div>
                    <div class="col-md-2 text-end">
                        <x-button-reset-filter route="transaksi-retur.index" class="btn btn-light w-100 fw-bold shadow-sm" style="height: 42px; border-radius: 8px;"/>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-sigma">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">#</th>
                            <th>No. Retur</th>
                            <th>Referensi Transaksi</th>
                            <th>Nama Pengirim</th>
                            <th>Item</th>
                            <th class="text-end">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($retur as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('transaksi-retur.show', $item->nomor_retur) }}" class="text-decoration-none">
                                    <span class="badge-code">{{ $item->nomor_retur }}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-muted small fw-bold">{{ $item->nomor_transaksi }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $item->transaksi->pengirim }}</div>
                            </td>
                            <td>
                                <span class="fw-bold">{{ number_format($item->jumlah_barang, 0) }}</span>
                                <span class="text-muted small">pcs</span>
                            </td>
                            <td class="text-end">
                                <span class="price-text text-dark">Rp{{ number_format($item->jumlah_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-search fa-2x mb-3 opacity-25"></i>
                                    <p class="m-0">Tidak ada data retur yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $retur->count() }} data dari total {{ $retur->total() }}
                </div>
                <div>
                    {{ $retur->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
