@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Kategori Barang</h4>
        <x-kategori-produk.form-kategori-produk />
    </div>
    <div class="card-body">

        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <x-per-page-option />
            </div>
            <div class="col-12 col-md-8">
                <x-filter-by-field term='search' placeholder="Cari kategori barang..." />
            </div>
            <div class="col-6 col-md-2">
                <x-button-reset-filter route="master-data.kategori-produk.index" />
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px">No</th>
                        <th style="width: 120px">Kode</th>
                        <th>Nama Kategori</th>
                        <th class="text-center" style="width: 130px">Jumlah Barang</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $item)
                    <tr>
                        <td class="text-muted">{{ $kategori->firstItem() + $index }}</td>
                        <td><span class="badge bg-secondary">{{ $item->kode_kategori }}</span></td>
                        <td>
                            <span class="fw-semibold" style="color: var(--sigma-navy-900)">{{ $item->nama_kategori }}</span>
                            @if($item->deskripsi)
                            <br><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $item->produks_count }} barang</span>
                        </td>
                        <td class="text-center">
                            <x-kategori-produk.form-kategori-produk
                                id="{{ $item->id }}"
                                nama_kategori="{{ $item->nama_kategori }}"
                                deskripsi="{{ $item->deskripsi }}"
                                action="{{ route('master-data.kategori-produk.update', $item->id) }}" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-inbox fa-2x text-muted mb-2 d-block opacity-50"></i>
                            <span class="text-muted">Data kategori belum tersedia</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
            <p class="text-muted small mb-0">
                Menampilkan {{ $kategori->firstItem() }} sampai {{ $kategori->lastItem() }} dari {{ $kategori->total() }} data
            </p>
            {{ $kategori->links() }}
        </div>

    </div>
</div>

@endsection
