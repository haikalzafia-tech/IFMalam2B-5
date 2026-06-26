@extends('layouts.kai')
@section('page_title', 'Kelola Lokasi Stok')
@section('content')

<style>
    .page-inner { background: #f8f9fa; min-height: 100vh; }
    .main-card-3d {
        border: none !important; border-radius: 20px !important; background: #f8f9fa;
        box-shadow: 12px 12px 24px #d1d9e6, -12px -12px 24px #ffffff !important; padding: 10px;
    }
    .filter-wrapper {
        background: #f8f9fa; border-radius: 15px; padding: 25px; margin-bottom: 25px;
        box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
    }
    .custom-table th, .custom-table td {
        white-space: nowrap; padding: 18px 20px !important; vertical-align: middle !important; border: none !important;
    }
    .custom-table thead th {
        background: transparent; border-bottom: 2px solid #eef0f2 !important; color: #495057;
        font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;
    }
    .custom-table tbody tr:hover { background: #ffffff !important; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

    .badge-location {
        background: #ffffff; border: 1px solid #eef0f2; border-radius: 8px; padding: 4px 10px;
        box-shadow: 2px 2px 4px #d1d9e6; font-size: 12px; margin-right: 5px; margin-bottom: 5px; display: inline-block;
    }

    .pagination-3d .pagination { gap: 8px; }
    .pagination-3d .page-link { border: none; border-radius: 10px; background: #f8f9fa; box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff; color: #495057; }
    .pagination-3d .page-item.active .page-link { background: #1a73e8; color: #fff; box-shadow: inset 3px 3px 6px #135ab5; }
</style>

<div class="container-fluid">
    <div class="page-inner py-4">
        <div class="card main-card-3d">
            <div class="card-body p-4">

                <div class="mb-4">
                    <h4 class="fw-bold m-0"><i class="fas fa-map-marked-alt me-2 text-primary"></i> Distribusi Stok per Rak</h4>
                    <p class="text-muted small mt-1">Kelola penempatan stok barang di lokasi rak secara mendetail.</p>
                </div>

                <div class="filter-wrapper">
                    <form method="GET" class="row g-2 align-items-center">
                        <div class="col-md-9">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama barang atau SKU..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Cari</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Barang / Varian</th>
                                <th>Total Stok</th>
                                <th>Jumlah Lokasi</th>
                                <th>Rincian Lokasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($varianProduks as $v)
                            <tr>
                                <td><span class="badge bg-light text-dark border">{{ $v->nomor_sku }}</span></td>
                                <td class="fw-bold">{{ $v->produk->nama_produk }} <br> <small class="text-primary">{{ $v->nama_varian }}</small></td>
                                <td><span class="fs-6 fw-bold text-dark">{{ number_format($v->stok_varian) }}</span></td>
                                <td>
                                    <span class="badge {{ $v->lokasiStoks->count() > 1 ? 'bg-info' : 'bg-secondary' }} text-white">
                                        {{ $v->lokasiStoks->count() }} rak
                                    </span>
                                </td>
                                <td style="max-width: 300px; white-space: normal;">
                                    @forelse($v->lokasiStoks->where('qty', '>', 0) as $lokasi)
                                        <div class="badge-location">
                                            <i class="fas fa-pallet me-1 text-secondary"></i>
                                            <strong>{{ $lokasi->rak->kode_rak ?? '-' }}</strong>: {{ $lokasi->qty }}
                                        </div>
                                    @empty
                                        <span class="text-muted small">Belum ada lokasi</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('lokasi-stok.edit', $v) }}" class="btn btn-sm btn-outline-warning shadow-sm">
                                        <i class="fas fa-map-marker-alt me-1"></i> Atur Lokasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada data barang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <div class="pagination-3d">
                        {{ $varianProduks->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
