@extends('layouts.kai')
@section('page_title', 'Data Zona')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Zona</h4>

        {{-- HANYA ADMIN YANG BISA TAMBAH ZONA --}}
        @if(Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('master-data.zona.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Zona
            </a>
        @endif
    </div>

    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-6">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama zona..." value="{{ request('search') }}">
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
                <button type="submit" class="btn btn-secondary btn-sm w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Kode</th>
                        <th>Nama Zona</th>
                        <th>Gudang</th>
                        <th>Jenis</th>
                        <th class="text-center">Jumlah Rak</th>
                        <th class="text-center">Status</th>

                        {{-- HANYA ADMIN YANG MELIHAT KOLOM AKSI --}}
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <th class="text-center" style="width: 110px">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($zonas as $zona)
                    <tr>
                        <td class="text-muted">{{ $zonas->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-primary">{{ $zona->kode_zona }}</span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)">{{ $zona->nama_zona }}</td>
                        <td>{{ $zona->gudang->nama_gudang }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($zona->jenis_zona) }}</span></td>
                        <td class="text-center"><span class="badge bg-info">{{ $zona->raks_count }} rak</span></td>
                        <td class="text-center">
                            <span class="badge bg-{{ $zona->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($zona->status) }}</span>
                        </td>

                        {{-- HANYA ADMIN YANG BISA EDIT/HAPUS --}}
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('master-data.zona.edit', $zona) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-zona-{{ $zona->id }}" action="{{ route('master-data.zona.destroy', $zona) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="SigmaNotif.konfirmasiHapus('delete-zona-{{ $zona->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr><td colspan="{{ Auth::user()->role == 'admin' ? 8 : 7 }}" class="text-center text-muted py-5">Belum ada data zona.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $zonas->links() }}</div>
    </div>
</div>
@endsection
