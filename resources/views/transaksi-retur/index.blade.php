@extends('layouts.kai')
@section('page_title', 'Transaksi Pengembalian')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Transaksi Pengembalian</h4>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalExport">
                <i class="fas fa-file-excel me-1"></i> Export
            </button>

            {{-- HANYA ADMIN YANG BISA MEMBUAT RETUR BARU --}}
            @if(Auth::check() && Auth::user()->role == 'admin')
                <a href="{{ route('transaksi-retur.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Pengembalian Baru
                </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-3">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nomor pengembalian..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-3">
                <select name="jenis_retur" class="form-select form-select-sm">
                    <option value="">-- Semua Jenis --</option>
                    <option value="retur_masuk" {{ request('jenis_retur') == 'retur_masuk' ? 'selected' : '' }}>Masuk ke Gudang</option>
                    <option value="retur_keluar" {{ request('jenis_retur') == 'retur_keluar' ? 'selected' : '' }}>Keluar ke Supplier</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="gudang_id" class="form-select form-select-sm">
                    <option value="">-- Semua Gudang --</option>
                    @foreach($gudangs as $g)
                    <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
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
                        <th>No. Pengembalian</th>
                        <th>Tanggal</th>
                        <th>Transaksi Asal</th>
                        <th>Jenis</th>
                        <th>Gudang</th>
                        <th>Alasan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 90px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returs as $r)
                    <tr>
                        <td class="text-muted">{{ $returs->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-secondary">{{ $r->nomor_retur }}</span></td>
                        <td>{{ $r->tanggal_retur->format('d/m/Y') }}</td>
                        <td>{{ $r->transaksi->nomor_transaksi }}</td>
                        <td>
                            <span class="badge bg-{{ $r->jenis_retur == 'retur_masuk' ? 'success' : 'warning' }}">
                                {{ $r->jenis_retur == 'retur_masuk' ? 'Masuk Gudang' : 'Keluar Supplier' }}
                            </span>
                        </td>
                        <td>{{ $r->gudang->nama_gudang }}</td>
                        <td>{{ Str::limit($r->alasan_retur, 30) }}</td>
                        <td class="text-center">
                            @php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; @endphp
                            <span class="badge bg-{{ $statusColor[$r->status] }}">{{ ucfirst($r->status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('transaksi-retur.show', $r) }}" class="btn btn-xs btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-5">Belum ada transaksi pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $returs->links() }}</div>
    </div>
</div>

<x-export-modal route="export.transaksi-retur" judul="Export Transaksi Pengembalian" />
@endsection
