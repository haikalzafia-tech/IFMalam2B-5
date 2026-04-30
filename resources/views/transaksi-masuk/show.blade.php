
@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    .main-card-detail {
        border: none !important;
        border-radius: 20px !important;
        background: #f8f9fa;
        box-shadow: 12px 12px 24px #d1d9e6, -12px -12px 24px #ffffff !important;
    }

    .info-section {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: inset 4px 4px 8px #d1d9e6, inset -4px -4px 8px #ffffff;
    }

    .detail-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #8898aa;
        font-weight: 700;
        display: block;
        margin-bottom: 2px;
    }

    .detail-value {
        font-weight: 600;
        color: #32325d;
        font-size: 14px;
    }

    .table-detail thead th {
        background: #f1f3f5;
        border: none;
        color: #495057;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .badge-batch {
        font-family: 'Monaco', monospace;
        background: #e9ecef;
        color: #1a73e8;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
    }

    .grand-total-box {
        background: #1a73e8;
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        text-align: right;
    }
</style>

<div class="container-fluid">
    <div class="page-inner py-4">
        <div class="card main-card-detail">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center p-4">
                <div class="d-flex align-items-center">
                    <div style="width: 4px; height: 24px; background: #1a73e8; border-radius: 10px; margin-right: 12px;"></div>
                    <h4 class="fw-bold m-0">Detail Transaksi: <span class="text-primary">#{{ $transaksi->nomor_transaksi }}</span></h4>
                </div>
                <a href="{{ route('transaksi-masuk.index') }}" class="btn btn-light btn-round border shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card-body p-4">
                <!-- Informasi Utama -->
                <div class="info-section">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <span class="detail-label">Nama Pengirim</span>
                            <span class="detail-value">{{ $transaksi->pengirim }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="detail-label">Kontak / HP</span>
                            <span class="detail-value">{{ $transaksi->kontak }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="detail-label">Tanggal Masuk</span>
                            <span class="detail-value">{{ $transaksi->formated_date }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="detail-label">Petugas Admin</span>
                            <span class="detail-value text-primary">{{ $transaksi->petugas }}</span>
                        </div>
                        <div class="col-12">
                            <span class="detail-label">Keterangan</span>
                            <span class="detail-value text-muted italic small">{{ $transaksi->keterangan ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Barang -->
                <div class="table-responsive mt-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-box-open me-2 text-primary"></i>Daftar Item Barang</h6>
                    <table class="table table-detail align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px">No</th>
                                <th>Produk & Varian</th>
                                <th class="text-center">No. Batch</th>
                                <th class="text-center">Jumlah Barang</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->items as $index => $item)
                            <tr>
                                <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                <td class="text-left">
                                    <span class="font-weight-bold text-dark">{{ $item->produk }}</span>
                                    <br>
                                    <small class="text-muted">Varian: {{ $item->varian }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge-batch">{{ $item->nomor_batch }}</span>
                                </td>
                                <td class="text-center fw-bold">{{ number_format($item->qty) }} <small>unit</small></td>
                                <td class="text-end">Rp {{ number_format($item->harga) }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($item->sub_total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Total -->
                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <div class="grand-total-box shadow-lg">
                            <span class="d-block small opacity-75">Grand Total Keseluruhan</span>
                            <h3 class="m-0 fw-bold">Rp {{ number_format($transaksi->total_harga) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top text-right">
                <small class="text-muted">Dicatat otomatis oleh Sistem Inventaris SIGMA - {{ now()->format('d/m/Y') }}</small>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
