@extends('layouts.kai')
@section('page_title', $pageTitle)

@section('content')
<style>
    /* Custom 3D Effect & Styling */
    .card-3d {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 1px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        background: #ffffff;
    }

    .header-gradient {
        background: linear-gradient(135deg, #1a2035 0%, #2c3e50 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border-left: 5px solid #1a2035;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        height: 100%;
    }

    .table-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table thead {
        background-color: #f1f4f8;
    }

    .badge-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #28a745;
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
    <div class="card card-3d">
        <!-- Header dengan Gradient -->
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
            <!-- Grid Informasi Utama -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="info-box">
                        <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Informasi Penerima</h6>
                        <div class="d-flex flex-column">
                            <x-meta-item label="Penerima" value="{{ $transaksi->penerima ?? '-' }}" />
                            <x-meta-item label="Kontak" value="{{ $transaksi->kontak ?? '-' }}" />
                            <x-meta-item label="Keterangan" value="{{ $transaksi->keterangan ?? '-' }}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-box" style="border-left-color: #28a745;">
                        <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Detail Penyerahan</h6>
                        <div class="d-flex flex-column">
                            <x-meta-item label="Petugas" value="{{ $transaksi->petugas }}" />
                            <x-meta-item label="Waktu" value="{{ $transaksi->formated_date }}" />
                            <x-meta-item label="Status" value="Selesai" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Barang -->
            <div class="mt-4">
                <h5 class="font-weight-bold mb-3"><i class="fas fa-box-open mr-2 text-primary"></i> Daftar Item Keluar</h5>
                <div class="table-responsive table-container">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th width="50">No</th>
                                <th class="text-left">Produk & Varian</th>
                                <th>Jumlah</th>
                                <th class="text-right">Harga Satuan</th>
                                <th class="text-right">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->items as $index => $item)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td class="text-left">
                                    <span class="font-weight-bold text-dark">{{ $item->produk }}</span>
                                    <br>
                                    <small class="text-muted">Varian: {{ $item->varian }}</small>
                                </td>
                                <td><span class="badge badge-info">{{ number_format($item->qty) }}</span></td>
                                <td class="text-right">Rp {{ number_format($item->harga) }}</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($item->sub_total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Kartu -->
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
@endsection
