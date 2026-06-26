@extends('layouts.kai')
@section('page_title', 'Data Gudang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Gudang</h4>
                <a href="{{ route('master-data.gudang.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Gudang
                </a>
            </div>
            <div class="card-body">
                {{-- Filter --}}
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-2">
                        <x-per-page-option />
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari nama / kode gudang..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-secondary w-100">Filter</button>
                    </div>
                    @if(request()->anyFilled(['search','status']))
                    <div class="col-md-2">
                        <a href="{{ route('master-data.gudang.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                    @endif
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Gudang</th>
                                <th>Kota</th>
                                <th>PIC</th>
                                <th>Zona</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gudangs as $gudang)
                            <tr>
                                <td>{{ $gudangs->firstItem() + $loop->index }}</td>
                                <td><span class="badge bg-secondary">{{ $gudang->kode_gudang }}</span></td>
                                <td>{{ $gudang->nama_gudang }}</td>
                                <td>{{ $gudang->kota }}, {{ $gudang->provinsi }}</td>
                                <td>{{ $gudang->pic_nama }}</td>
                                <td><span class="badge bg-info">{{ $gudang->zonas_count }} zona</span></td>
                                <td>
                                    <span class="badge bg-{{ $gudang->status == 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($gudang->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.gudang.show', $gudang) }}" class="btn btn-xs btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('master-data.gudang.edit', $gudang) }}" class="btn btn-xs btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-gudang-{{ $gudang->id }}" action="{{ route('master-data.gudang.destroy', $gudang) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger" title="Hapus"
                                        onclick="SigmaNotif.konfirmasiHapus('delete-gudang-{{ $gudang->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted">Belum ada data gudang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $gudangs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
