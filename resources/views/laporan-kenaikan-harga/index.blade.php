@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    .page-inner { background: #f1f3f7; perspective: 1000px; }

    /* Card Utama */
    .card-3d {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.6);
        overflow: hidden;
    }

    .header-3d {
        background: #1a2035;
        color: #fff;
        padding: 25px 30px;
        border-bottom: 4px solid #ffc107; /* Warna Kuning untuk Alert/Monitoring */
    }

    /* Table Styling */
    .table-container-3d {
        margin: 20px;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.02);
    }

    .table-3d { margin-bottom: 0 !important; }
    .table-3d thead { background: #f8f9fa; }
    .table-3d th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #6c757d;
        padding: 15px;
        border: none !important;
    }
    .table-3d td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1 !important;
    }

    /* Font Monospace untuk Angka agar rapi */
    .font-number { font-family: 'Monaco', 'Consolas', monospace; font-weight: 600; }

    /* Badge & Alert Styles */
    .price-up { color: #d32f2f; font-weight: 800; }
    .badge-qty { background: #e8f0fe; color: #1967d2; font-weight: 700; padding: 5px 12px; border-radius: 8px; }

    /* Button Custom */
    .btn-confirm-3d {
        background: #ffffff;
        border: 2px solid #1a2035;
        color: #1a2035;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s;
        box-shadow: 0 4px 0 #1a2035;
    }

    .btn-confirm-3d:hover {
        background: #1a2035;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #000;
    }

    .btn-confirm-3d:active {
        transform: translateY(4px);
        box-shadow: 0 0 0 #000;
    }
</style>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-3d p-3 border-left-warning">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-warning text-white me-3 p-3 rounded-circle">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold mb-0 uppercase">Total Item Naik</p>
                    <h3 class="fw-bold mb-0">{{ count($laporan) }} Barang</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-3d">
    <div class="header-3d d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Monitoring Perubahan Harga</h4>
            <p class="mb-0 text-white-50 small">Daftar item masuk dengan harga lebih tinggi dari stok lama.</p>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-container-3d">
            <div class="table-responsive">
                <table class="table table-hover table-3d">
                    <thead class="text-center">
                        <tr>
                            <th width="50">No</th>
                            <th class="text-start">Barang & Transaksi</th>
                            <th>Batch</th>
                            <th class="text-end">Harga Lama</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="text-end">Selisih</th>
                            <th>Qty</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $index => $item)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start">
                                <span class="fw-bold text-dark d-block">{{ $item->varian->nama_produk }} {{ $item->varian->nama_varian }}</span>
                                <small class="text-muted font-number">{{ $item->nomor_transaksi }}</small>
                            </td>
                            <td><span class="badge border text-dark fw-bold">{{ $item->nomor_batch }}</span></td>
                            <td class="text-end font-number text-muted">Rp {{ number_format($item->harga_lama) }}</td>
                            <td class="text-end font-number fw-bold text-dark">Rp {{ number_format($item->harga_beli) }}</td>
                            <td class="text-end font-number price-up">
                                <i class="fas fa-arrow-up small me-1"></i> Rp {{ number_format($item->kenaikan_harga) }}
                            </td>
                            <td><span class="badge-qty">{{ number_format($item->jumlah_barang) }} pcs</span></td>
                            <td>
                                <a href="{{ route('master-data.produk.show', $item->varian->produk->id) }}" class="btn btn-confirm-3d btn-sm px-3">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-check-circle fa-3x mb-3 text-success d-block"></i>
                                <span class="fw-bold">Tidak ada lonjakan harga terdeteksi.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
