@extends('layouts.kai')
@section('page_title', 'Data Rak')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Rak Gudang</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.rak') }}" class="btn btn-success btn-sm" title="Export ke Excel">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                    <a href="{{ route('master-data.rak.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Rak
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-2">
                        <x-per-page-option />
                    </div>
                    <div class="col-md-3">
                        <select name="gudang_id" class="form-select form-select-sm">
                            <option value="">-- Semua Gudang --</option>
                            @foreach($gudangs as $g)
                            <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="zona_id" class="form-select form-select-sm">
                            <option value="">-- Semua Zona --</option>
                            @foreach($zonas as $z)
                            <option value="{{ $z->id }}" {{ request('zona_id') == $z->id ? 'selected' : '' }}>
                                {{ $z->gudang->nama_gudang }} - {{ $z->nama_zona }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="penuh" {{ request('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-secondary w-100">Filter</button>
                    </div>
                    @if(request()->anyFilled(['gudang_id','zona_id','status']))
                    <div class="col-md-2">
                        <a href="{{ route('master-data.rak.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                    @endif
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode Rak</th>
                                <th>Nama Rak</th>
                                <th>Zona</th>
                                <th>Gudang</th>
                                <th>Kapasitas</th>
                                <th>Terpakai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($raks as $rak)
                            @php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; @endphp
                            <tr>
                                <td>{{ $raks->firstItem() + $loop->index }}</td>
                                <td><span class="badge bg-secondary">{{ $rak->kode_rak }}</span></td>
                                <td>{{ $rak->nama_rak }}</td>
                                <td>{{ $rak->zona->nama_zona }}</td>
                                <td>{{ $rak->zona->gudang->nama_gudang }}</td>
                                <td>{{ number_format($rak->kapasitas_total) }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height:8px; min-width:60px;">
                                            <div class="progress-bar bg-{{ $persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success') }}"
                                                style="width:{{ $persen }}%"></div>
                                        </div>
                                        <small>{{ $persen }}%</small>
                                    </div>
                                    <small class="text-muted">{{ $rak->kapasitas_terpakai }}/{{ $rak->kapasitas_total }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($rak->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.rak.show', $rak) }}" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('master-data.rak.edit', $rak) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-rak-{{ $rak->id }}" action="{{ route('master-data.rak.destroy', $rak) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger"
                                        onclick="SigmaNotif.konfirmasiHapus('delete-rak-{{ $rak->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center text-muted">Belum ada data rak.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $raks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
