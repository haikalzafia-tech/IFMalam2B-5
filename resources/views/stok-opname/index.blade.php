@extends('layouts.kai')
@section('page_title', 'Stok Opname')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Stok Opname</h4>

        {{-- HANYA ADMIN YANG BISA MEMBUAT STOK OPNAME BARU --}}
        @if(Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('stok-opname.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Buat Opname Baru
            </a>
        @endif
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-6 col-md-4">
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
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
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
                        <th>No. Opname</th>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Petugas</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opnames as $o)
                    <tr>
                        <td class="text-muted">{{ $opnames->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-primary">{{ $o->nomor_opname }}</span></td>
                        <td>{{ $o->tanggal_opname->format('d/m/Y') }}</td>
                        <td>{{ $o->gudang->nama_gudang }}</td>
                        <td>{{ $o->petugas }}</td>
                        <td class="text-center">
                            @php $statusColor = ['draft'=>'secondary','berlangsung'=>'warning','selesai'=>'success']; @endphp
                            <span class="badge bg-{{ $statusColor[$o->status] }}">{{ ucfirst($o->status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('stok-opname.show', $o) }}" class="btn btn-xs btn-info">
                                <i class="fas fa-eye"></i> {{ $o->status == 'berlangsung' ? 'Lanjutkan' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada data stok opname.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $opnames->links() }}</div>
    </div>
</div>
@endsection
