@extends('layouts.kai')
@section('page_title', 'Data Gudang')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Gudang</h4>

        {{-- HANYA ADMIN yang bisa melihat tombol Tambah Gudang --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('master-data.gudang.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Gudang
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
                    placeholder="Cari nama / kode gudang..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Kode</th>
                        <th>Nama Gudang</th>
                        <th>Kota</th>
                        <th>PIC</th>
                        <th class="text-center">Zona</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gudangs as $gudang)
                    <tr>
                        <td class="text-muted">{{ $gudangs->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-secondary">{{ $gudang->kode_gudang }}</span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)">{{ $gudang->nama_gudang }}</td>
                        <td>{{ $gudang->kota }}, {{ $gudang->provinsi }}</td>
                        <td>{{ $gudang->pic_nama }}</td>
                        <td class="text-center"><span class="badge bg-info">{{ $gudang->zonas_count }} zona</span></td>
                        <td class="text-center">
                            <span class="badge bg-{{ $gudang->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($gudang->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                {{-- KEDUA ROLE (Admin & Manager) bisa melihat detail --}}
                                <a href="{{ route('master-data.gudang.show', $gudang) }}" class="btn btn-xs btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- HANYA ADMIN yang bisa mengedit dan menghapus --}}
                                @if(Auth::check() && Auth::user()->role === 'admin')
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
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-5">Belum ada data gudang.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $gudangs->links() }}</div>
    </div>
</div>
@endsection
