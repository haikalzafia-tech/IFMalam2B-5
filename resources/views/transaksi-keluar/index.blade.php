@extends('layouts.kai')
@section('page_title', 'Transaksi Keluar')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Transaksi Keluar</h4>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalExport">
                <i class="fas fa-file-excel me-1"></i> Export
            </button>

            {{-- HANYA ADMIN YANG BISA MEMBUAT TRANSAKSI KELUAR BARU --}}
            @if(Auth::check() && Auth::user()->role == 'admin')
                <a href="{{ route('transaksi-keluar.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Transaksi Baru
                </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nomor transaksi..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-3">
                <select name="gudang_id" class="form-select form-select-sm">
                    <option value="">-- Semua Gudang --</option>
                    @foreach($gudangs as $g)
                    <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Penerima</th>
                        <th>Tujuan</th>
                        <th class="text-center">Jml Barang</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 90px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr>
                        <td class="text-muted">{{ $transaksis->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-primary">{{ $t->nomor_transaksi }}</span></td>
                        <td>{{ $t->tanggal_transaksi->format('d/m/Y') }}</td>
                        <td>{{ $t->gudang->nama_gudang }}</td>
                        <td>{{ $t->penerima }}</td>
                        <td>{{ $t->tujuan ?? '-' }}</td>
                        <td class="text-center fw-semibold">{{ $t->jumlah_barang }}</td>
                        <td class="text-center">
                            @php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; @endphp
                            <span class="badge bg-{{ $statusColor[$t->status] }}">{{ ucfirst($t->status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('transaksi-keluar.show', $t) }}" class="btn btn-xs btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-5">Belum ada transaksi keluar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $transaksis->links() }}</div>
    </div>
</div>

<x-export-modal route="export.transaksi-keluar" judul="Export Transaksi Keluar" />
@endsection
