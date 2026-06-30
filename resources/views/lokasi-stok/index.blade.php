@extends('layouts.kai')
@section('page_title', 'Kelola Lokasi Stok')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Distribusi Stok per Rak</h4>
        <p class="text-muted small mb-0">Kelola di rak mana saja stok suatu barang berada, terutama untuk barang yang tersebar di lebih dari satu rak.</p>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama barang / SKU..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th class="text-center">Total Stok</th>
                        <th class="text-center">Jumlah Lokasi</th>
                        <th>Rincian Lokasi</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($varianProduks as $v)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $v->nomor_sku }}</span></td>
                        <td class="fw-semibold">{{ $v->produk->nama_produk }} - {{ $v->nama_varian }}</td>
                        <td class="text-center fw-bold">{{ $v->stok_varian }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $v->lokasiStoks->count() > 1 ? 'info' : 'secondary' }}">
                                {{ $v->lokasiStoks->count() }} rak
                            </span>
                        </td>
                        <td>
                            @forelse($v->lokasiStoks->where('qty', '>', 0) as $lokasi)
                                <span class="badge bg-secondary me-1 mb-1">
                                    {{ $lokasi->rak->kode_rak ?? '-' }}: {{ $lokasi->qty }}
                                </span>
                            @empty
                                <span class="text-muted small">Belum ada lokasi</span>
                            @endforelse
                        </td>
                        <td class="text-center">
                            <a href="{{ route('lokasi-stok.edit', $v) }}" class="btn btn-xs btn-warning">
                                <i class="fas fa-map-marker-alt me-1"></i> Atur
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada data barang.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $varianProduks->links() }}</div>
    </div>
</div>
@endsection
