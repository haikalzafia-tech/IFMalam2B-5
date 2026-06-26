@extends('layouts.kai')
@section('page_title', 'Data Supplier')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Supplier</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.supplier') }}" class="btn btn-success btn-sm" title="Export ke Excel">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                    <a href="{{ route('master-data.supplier.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Supplier
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-2">
                        <x-per-page-option />
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari nama / kode supplier..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="jenis" class="form-select form-select-sm">
                            <option value="">-- Semua Jenis --</option>
                            <option value="produsen" {{ request('jenis') == 'produsen' ? 'selected' : '' }}>Produsen</option>
                            <option value="distributor" {{ request('jenis') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                            <option value="agen" {{ request('jenis') == 'agen' ? 'selected' : '' }}>Agen</option>
                            <option value="retailer" {{ request('jenis') == 'retailer' ? 'selected' : '' }}>Retailer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-secondary w-100">Filter</button>
                    </div>
                    @if(request()->anyFilled(['search','jenis','status']))
                    <div class="col-md-1">
                        <a href="{{ route('master-data.supplier.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                    @endif
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Supplier</th>
                                <th>Jenis</th>
                                <th>PIC</th>
                                <th>Telepon</th>
                                <th>Kota</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                <td><span class="badge bg-secondary">{{ $supplier->kode_supplier }}</span></td>
                                <td>{{ $supplier->nama_supplier }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($supplier->jenis_supplier) }}</span></td>
                                <td>{{ $supplier->pic_nama }}</td>
                                <td>{{ $supplier->telepon }}</td>
                                <td>{{ $supplier->kota }}</td>
                                <td>
                                    <span class="badge bg-{{ $supplier->status == 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($supplier->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.supplier.show', $supplier) }}" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('master-data.supplier.edit', $supplier) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-supplier-{{ $supplier->id }}" action="{{ route('master-data.supplier.destroy', $supplier) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger"
                                        onclick="SigmaNotif.konfirmasiHapus('delete-supplier-{{ $supplier->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center text-muted">Belum ada data supplier.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
