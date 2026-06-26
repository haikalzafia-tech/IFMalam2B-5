@extends('layouts.kai')
@section('page_title', 'Data Zona')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Zona</h4>
                <a href="{{ route('master-data.zona.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Zona
                </a>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-2">
                        <x-per-page-option />
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari nama zona..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="gudang_id" class="form-select form-select-sm">
                            <option value="">-- Semua Gudang --</option>
                            @foreach($gudangs as $g)
                            <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-secondary w-100">Filter</button>
                    </div>
                    @if(request()->anyFilled(['search','gudang_id']))
                    <div class="col-md-2">
                        <a href="{{ route('master-data.zona.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                    @endif
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Zona</th>
                                <th>Gudang</th>
                                <th>Jenis</th>
                                <th>Jumlah Rak</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($zonas as $zona)
                            <tr>
                                <td>{{ $zonas->firstItem() + $loop->index }}</td>
                                <td><span class="badge bg-primary">{{ $zona->kode_zona }}</span></td>
                                <td>{{ $zona->nama_zona }}</td>
                                <td>{{ $zona->gudang->nama_gudang }}</td>
                                <td>
                                    @php
                                        $jenisColor = ['reguler'=>'secondary','dingin'=>'info','berbahaya'=>'danger','karantina'=>'warning','ekspedisi'=>'primary'];
                                    @endphp
                                    <span class="badge bg-{{ $jenisColor[$zona->jenis_zona] ?? 'secondary' }}">
                                        {{ ucfirst($zona->jenis_zona) }}
                                    </span>
                                </td>
                                <td><span class="badge bg-info">{{ $zona->raks_count }} rak</span></td>
                                <td>
                                    <span class="badge bg-{{ $zona->status == 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($zona->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.zona.edit', $zona) }}" class="btn btn-xs btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-zona-{{ $zona->id }}" action="{{ route('master-data.zona.destroy', $zona) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger"
                                        onclick="SigmaNotif.konfirmasiHapus('delete-zona-{{ $zona->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted">Belum ada data zona.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $zonas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
