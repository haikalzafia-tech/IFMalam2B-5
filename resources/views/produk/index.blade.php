@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Data Barang</h4>
        <div class="d-flex gap-2">
            <x-produk.form-produk />
        </div>
    </div>
    <div class="card-body">

        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-8">
                <x-filter-by-field term="search" placeholder="Cari nama barang..." />
            </div>
            <div class="col-6 col-md-2">
                <x-button-reset-filter route="master-data.produk.index" />
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px">No</th>
                        <th>Barang</th>
                        <th>Kategori</th>
                        <th class="text-center">Total Stok</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $index => $item)
                    @php
                        $totalStok = $item->varianProduks->sum('stok_varian');
                        $statusStok = $totalStok <= 0 ? 'danger' : ($totalStok < $item->stok_minimum ? 'warning' : 'success');
                    @endphp
                    <tr>
                        <td class="text-muted">{{ $produk->firstItem() + $index }}</td>
                        <td>
                            <a href="{{ route('master-data.produk.show', $item->id) }}" class="fw-semibold text-decoration-none" style="color: var(--sigma-navy-700)">
                                {{ $item->nama_produk }}
                            </a>
                            <br><small class="text-muted">{{ $item->kode_produk }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $item->kategoriProduk?->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $statusStok }}">
                                {{ number_format($totalStok) }} {{ $item->satuan }}
                            </span>
                        </td>
                        <td class="text-center">
                            <x-produk.form-produk id="{{ $item->id }}" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-boxes fa-2x text-muted mb-2 d-block opacity-50"></i>
                            <span class="text-muted">Data barang tidak tersedia</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
            <p class="text-muted small mb-0">
                Menampilkan {{ $produk->firstItem() }} sampai {{ $produk->lastItem() }} dari {{ $produk->total() }} produk
            </p>
            {{ $produk->links() }}
        </div>

    </div>
</div>

@endsection
