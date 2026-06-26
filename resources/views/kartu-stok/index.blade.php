@extends('layouts.kai')
@section('page_title', 'Kartu Stok')

@section('content')
<style>
    /* Styling Neumorphism yang Konsisten */
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

    /* Pagination Seragam */
    .pagination-3d .pagination { gap: 8px; justify-content: center; }
    .pagination-3d .page-link {
        border: none !important; border-radius: 12px !important; background: #f8f9fa !important;
        box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff !important;
        color: #495057 !important; padding: 8px 16px;
    }
    .pagination-3d .page-item.active .page-link {
        background: #1a73e8 !important; color: #fff !important;
        box-shadow: inset 3px 3px 6px #135ab5 !important;
    }
</style>

<div class="container-fluid">
    <div class="page-inner py-4">
        <div class="card main-card-3d">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0"><i class="fas fa-history me-2 text-primary"></i> Kartu Stok - Log Pergerakan</h4>
                    <a href="{{ route('export.kartu-stok', request()->query()) }}" class="btn btn-success shadow-sm">
                        <i class="fas fa-file-excel me-1"></i> Export Data
                    </a>
                </div>

                <div class="filter-wrapper">
                    <form method="GET" class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <select name="nomor_sku" class="form-select">
                                <option value="">-- Semua Barang --</option>
                                @foreach($varianProduks as $v)
                                <option value="{{ $v->nomor_sku }}" {{ request('nomor_sku') == $v->nomor_sku ? 'selected' : '' }}>
                                    {{ $v->nomor_sku }} - {{ $v->produk->nama_produk }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="gudang_id" class="form-select">
                                <option value="">-- Semua Gudang --</option>
                                @foreach($gudangs as $g)
                                <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="jenis_transaksi" class="form-select">
                                <option value="">-- Semua Jenis --</option>
                                <option value="in" {{ request('jenis_transaksi') == 'in' ? 'selected' : '' }}>Masuk</option>
                                <option value="out" {{ request('jenis_transaksi') == 'out' ? 'selected' : '' }}>Keluar</option>
                                <option value="retur" {{ request('jenis_transaksi') == 'retur' ? 'selected' : '' }}>Retur</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-secondary w-100">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>Gudang</th>
                                <th>Ref. Transaksi</th>
                                <th>Jenis</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Stok Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kartuStoks as $k)
                            <tr>
                                <td>{{ $k->created_at->format('d/m/Y H:i') }}</td>
                                <td><span class="badge bg-light border text-dark">{{ $k->varianProduk->nomor_sku }}</span></td>
                                <td class="fw-bold">{{ $k->varianProduk->produk->nama_produk }} <br><small class="text-muted">{{ $k->varianProduk->nama_varian }}</small></td>
                                <td>{{ $k->gudang->nama_gudang }}</td>
                                <td><span class="text-muted">{{ $k->nomor_transaksi ?? '-' }}</span></td>
                                <td>
                                    @php
                                        $color = ['in'=>'bg-success', 'out'=>'bg-danger', 'retur'=>'bg-warning', 'adjustment'=>'bg-info'];
                                    @endphp
                                    <span class="badge {{ $color[$k->jenis_transaksi] ?? 'bg-secondary' }} text-white">
                                        {{ ucfirst($k->jenis_transaksi) }}
                                    </span>
                                </td>
                                <td class="text-success fw-bold">{{ $k->jumlah_masuk > 0 ? '+'.$k->jumlah_masuk : '-' }}</td>
                                <td class="text-danger fw-bold">{{ $k->jumlah_keluar > 0 ? '-'.$k->jumlah_keluar : '-' }}</td>
                                <td><span class="badge bg-dark">{{ $k->stok_akhir }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <p class="text-muted small mb-3 mb-md-0">
                        Menampilkan {{ $kartuStoks->firstItem() ?? 0 }} sampai {{ $kartuStoks->lastItem() ?? 0 }} dari {{ $kartuStoks->total() }} data
                    </p>
                    <div class="pagination-3d">
                        {{ $kartuStoks->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
