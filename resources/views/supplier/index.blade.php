@extends('layouts.kai')
@section('page_title', 'Data Supplier')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Supplier</h4>

        {{-- HANYA ADMIN YANG BISA TAMBAH SUPPLIER --}}
        @if(Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('master-data.supplier.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Supplier
            </a>
        @endif
    </div>

    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama / kode supplier..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">-- Semua Jenis --</option>
                    <option value="produsen" {{ request('jenis') == 'produsen' ? 'selected' : '' }}>Produsen</option>
                    <option value="distributor" {{ request('jenis') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                    <option value="agen" {{ request('jenis') == 'agen' ? 'selected' : '' }}>Agen</option>
                    <option value="retailer" {{ request('jenis') == 'retailer' ? 'selected' : '' }}>Retailer</option>
                </select>
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Kode</th>
                        <th>Nama Supplier</th>
                        <th>Jenis</th>
                        <th>PIC</th>
                        <th>Telepon</th>
                        <th>Kota</th>
                        <th class="text-center">Status</th>

                        {{-- HANYA ADMIN YANG MELIHAT KOLOM AKSI --}}
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <th class="text-center" style="width: 130px">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td class="text-muted">{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-secondary">{{ $supplier->kode_supplier }}</span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)">{{ $supplier->nama_supplier }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($supplier->jenis_supplier) }}</span></td>
                        <td>{{ $supplier->pic_nama }}</td>
                        <td>{{ $supplier->telepon }}</td>
                        <td>{{ $supplier->kota }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $supplier->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($supplier->status) }}</span>
                        </td>

                        {{-- HANYA ADMIN YANG BISA EDIT/HAPUS --}}
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('master-data.supplier.show', $supplier) }}" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('master-data.supplier.edit', $supplier) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-supplier-{{ $supplier->id }}" action="{{ route('master-data.supplier.destroy', $supplier) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="SigmaNotif.konfirmasiHapus('delete-supplier-{{ $supplier->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr><td colspan="{{ Auth::check() && Auth::user()->role == 'admin' ? 9 : 8 }}" class="text-center text-muted py-5">Belum ada data supplier.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $suppliers->links() }}</div>
    </div>
</div>
@endsection
