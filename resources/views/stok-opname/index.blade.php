@extends('layouts.kai')
@section('page_title', 'Stok Opname')

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
                    <h4 class="fw-bold m-0"><i class="fas fa-clipboard-check me-2 text-primary"></i> Daftar Stok Opname</h4>
                    <a href="{{ route('stok-opname.create') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus me-1"></i> Opname Baru
                    </a>
                </div>

                <div class="filter-wrapper">
                    <form method="GET" class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <select name="gudang_id" class="form-select">
                                <option value="">-- Semua Gudang --</option>
                                @foreach($gudangs as $g)
                                <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="">-- Semua Status --</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-secondary w-100">Filter Data</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Opname</th>
                                <th>Tanggal</th>
                                <th>Gudang</th>
                                <th>Petugas</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($opnames as $index => $o)
                            <tr>
                                <td>{{ $opnames->firstItem() + $index }}</td>
                                <td><span class="badge bg-light text-primary border">{{ $o->nomor_opname }}</span></td>
                                <td>{{ $o->tanggal_opname->format('d/m/Y') }}</td>
                                <td>{{ $o->gudang->nama_gudang }}</td>
                                <td>{{ $o->petugas }}</td>
                                <td>
                                    @php
                                        $statusColor = ['draft'=>'bg-secondary', 'berlangsung'=>'bg-warning', 'selesai'=>'bg-success'];
                                    @endphp
                                    <span class="badge {{ $statusColor[$o->status] ?? 'bg-secondary' }} text-white">
                                        {{ ucfirst($o->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('stok-opname.show', $o) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye me-1"></i> {{ $o->status == 'berlangsung' ? 'Lanjutkan' : 'Detail' }}
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data stok opname.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <p class="text-muted small mb-3 mb-md-0">
                        Menampilkan {{ $opnames->firstItem() ?? 0 }} sampai {{ $opnames->lastItem() ?? 0 }} dari {{ $opnames->total() }} data
                    </p>
                    <div class="pagination-3d">
                        {{ $opnames->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
