@extends('layouts.kai')
@section('page_title', 'Data Rak')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Rak Gudang</h4>

        {{-- HANYA ADMIN YANG BISA TAMBAH RAK --}}
        @if(Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('master-data.rak.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Rak
            </a>
        @endif
    </div>

    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
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
                <select name="zona_id" class="form-select form-select-sm">
                    <option value="">-- Semua Zona --</option>
                    @foreach($zonas as $z)
                    <option value="{{ $z->id }}" {{ request('zona_id') == $z->id ? 'selected' : '' }}>
                        {{ $z->gudang->nama_gudang }} - {{ $z->nama_zona }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="penuh" {{ request('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Kode Rak</th>
                        <th>Nama Rak</th>
                        <th>Zona</th>
                        <th>Gudang</th>
                        <th>Kapasitas</th>
                        <th>Terpakai</th>
                        <th class="text-center">Status</th>

                        {{-- HANYA ADMIN YANG MELIHAT KOLOM AKSI --}}
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <th class="text-center" style="width: 130px">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($raks as $rak)
                    @php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; @endphp
                    <tr>
                        <td class="text-muted">{{ $raks->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-secondary">{{ $rak->kode_rak }}</span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)">{{ $rak->nama_rak }}</td>
                        <td>{{ $rak->zona->nama_zona }}</td>
                        <td>{{ $rak->zona->gudang->nama_gudang }}</td>
                        <td>{{ number_format($rak->kapasitas_total) }}</td>
                        <td style="min-width: 130px;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:7px;">
                                    <div class="progress-bar bg-{{ $persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success') }}"
                                        style="width:{{ $persen }}%"></div>
                                </div>
                                <small class="text-muted">{{ $persen }}%</small>
                            </div>
                            <small class="text-muted">{{ $rak->kapasitas_terpakai }}/{{ $rak->kapasitas_total }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($rak->status) }}
                            </span>
                        </td>

                        {{-- HANYA ADMIN YANG BISA EDIT/HAPUS --}}
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('master-data.rak.show', $rak) }}" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('master-data.rak.edit', $rak) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-rak-{{ $rak->id }}" action="{{ route('master-data.rak.destroy', $rak) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="SigmaNotif.konfirmasiHapus('delete-rak-{{ $rak->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr><td colspan="{{ Auth::check() && Auth::user()->role == 'admin' ? 9 : 8 }}" class="text-center text-muted py-5">Belum ada data rak.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $raks->links() }}</div>
    </div>
</div>
@endsection
