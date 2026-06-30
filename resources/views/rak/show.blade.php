@extends('layouts.kai')
@section('page_title', 'Detail Rak')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Rak</h4>
                <a href="{{ route('master-data.rak.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-3">
                    <tr><td class="text-muted">Kode</td><td><span class="badge bg-secondary">{{ $rak->kode_rak }}</span></td></tr>
                    <tr><td class="text-muted">Nama</td><td class="fw-semibold">{{ $rak->nama_rak }}</td></tr>
                    <tr><td class="text-muted">Zona</td><td>{{ $rak->zona->nama_zona }}</td></tr>
                    <tr><td class="text-muted">Gudang</td><td>{{ $rak->zona->gudang->nama_gudang }}</td></tr>
                    <tr><td class="text-muted">Baris &times; Kolom</td><td>{{ $rak->jumlah_baris }} &times; {{ $rak->jumlah_kolom }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge bg-{{ $rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary') }}">{{ ucfirst($rak->status) }}</span></td>
                    </tr>
                </table>

                @php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; @endphp
                <hr style="border-color: var(--sigma-border)">
                <h6 class="text-center mb-2 text-muted small">Kapasitas</h6>
                <div class="text-center mb-2">
                    <h3 class="fw-bold mb-0" style="color: {{ $persen >= 90 ? 'var(--sigma-danger)' : ($persen >= 70 ? 'var(--sigma-warning)' : 'var(--sigma-success)') }}">{{ $persen }}%</h3>
                </div>
                <div class="progress mb-3" style="height: 9px;">
                    <div class="progress-bar bg-{{ $persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success') }}" style="width:{{ $persen }}%"></div>
                </div>
                <div class="row text-center">
                    <div class="col-4"><h6 class="fw-bold mb-0">{{ $rak->kapasitas_terpakai }}</h6><small class="text-muted">Terpakai</small></div>
                    <div class="col-4"><h6 class="fw-bold mb-0">{{ $rak->sisa_kapasitas }}</h6><small class="text-muted">Sisa</small></div>
                    <div class="col-4"><h6 class="fw-bold mb-0">{{ $rak->kapasitas_total }}</h6><small class="text-muted">Total</small></div>
                </div>

                {{-- HANYA ADMIN YANG BISA EDIT RAK --}}
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('master-data.rak.edit', $rak) }}" class="btn btn-warning btn-sm w-100 mt-3">
                        <i class="fas fa-edit me-1"></i> Edit Rak
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Barang di Rak Ini</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>SKU</th>
                                <th>Nama Barang</th>
                                <th>Varian</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center" style="width: 130px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rak->varianProduks as $varian)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $varian->nomor_sku }}</span></td>
                                <td class="fw-semibold">{{ $varian->produk->nama_produk }}</td>
                                <td>{{ $varian->nama_varian }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $varian->stok_varian <= 0 ? 'danger' : ($varian->stok_varian < 10 ? 'warning' : 'success') }}">
                                        {{ $varian->stok_varian }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('kartu-stok.show', $varian->nomor_sku) }}" class="btn btn-xs btn-info">
                                        <i class="fas fa-clipboard-list"></i> Kartu Stok
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">Belum ada barang di rak ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
