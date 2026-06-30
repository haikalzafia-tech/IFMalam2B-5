@extends('layouts.kai')
@section('page_title', 'Detail Gudang')

@section('content')
<div class="row g-3">
    {{-- Sisi Kiri: Info Gudang --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Gudang</h4>
                <a href="{{ route('master-data.gudang.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-2">
                    <tr><td class="text-muted">Kode</td><td><span class="badge bg-secondary">{{ $gudang->kode_gudang }}</span></td></tr>
                    <tr><td class="text-muted">Nama</td><td class="fw-semibold">{{ $gudang->nama_gudang }}</td></tr>
                    <tr><td class="text-muted">Alamat</td><td>{{ $gudang->alamat }}</td></tr>
                    <tr><td class="text-muted">Kota</td><td>{{ $gudang->kota }}, {{ $gudang->provinsi }}</td></tr>
                    <tr><td class="text-muted">PIC</td><td>{{ $gudang->pic_nama }}</td></tr>
                    <tr><td class="text-muted">Telepon</td><td>{{ $gudang->pic_telepon ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge bg-{{ $gudang->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($gudang->status) }}</span></td>
                    </tr>
                </table>

                {{-- HANYA ADMIN YANG BISA EDIT GUDANG --}}
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('master-data.gudang.edit', $gudang) }}" class="btn btn-warning btn-sm w-100">
                        <i class="fas fa-edit me-1"></i> Edit Gudang
                    </a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h4 class="card-title">Kapasitas Gudang</h4></div>
            <div class="card-body text-center">
                <h2 class="fw-bold mb-1" style="color: var(--sigma-{{ $persentase >= 90 ? 'danger' : ($persentase >= 70 ? 'warning' : 'success') }})">
                    {{ $persentase }}%
                </h2>
                <p class="text-muted small mb-3">Terpakai</p>
                <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar bg-{{ $persentase >= 90 ? 'danger' : ($persentase >= 70 ? 'warning' : 'success') }}"
                        style="width: {{ $persentase }}%"></div>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="fw-bold mb-0">{{ number_format($totalTerpakai) }}</h5>
                        <small class="text-muted">Terpakai</small>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold mb-0">{{ number_format($totalKapasitas) }}</h5>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sisi Kanan: Layout Zona & Rak --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Layout Zona & Rak</h4>

                {{-- HANYA ADMIN YANG BISA TAMBAH ZONA --}}
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('master-data.zona.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Zona
                    </a>
                @endif
            </div>
            <div class="card-body">
                @forelse($gudang->zonas as $zona)
                <div class="mb-4 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">
                            <span class="badge bg-primary me-2">{{ $zona->kode_zona }}</span>
                            <span class="fw-semibold">{{ $zona->nama_zona }}</span>
                            <small class="text-muted ms-1">({{ ucfirst($zona->jenis_zona) }})</small>
                        </h6>
                        <span class="badge bg-{{ $zona->status == 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($zona->status) }}</span>
                    </div>

                    @if($zona->raks->count() > 0)
                    <div class="row g-2">
                        @foreach($zona->raks as $rak)
                        @php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; @endphp
                        <div class="col-sm-6 col-lg-4">
                            <div class="border rounded-3 p-2" style="border-color: var(--sigma-border) !important;">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong class="small">{{ $rak->kode_rak }}</strong>
                                    <span class="badge bg-{{ $rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($rak->status) }}
                                    </span>
                                </div>
                                <small class="text-muted d-block mb-1">{{ $rak->nama_rak }}</small>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-{{ $persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success') }}"
                                        style="width: {{ $persen }}%"></div>
                                </div>
                                <small class="text-muted">{{ $rak->kapasitas_terpakai }}/{{ $rak->kapasitas_total }} ({{ $persen }}%)</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    {{-- HANYA ADMIN YANG BISA TAMBAH RAK --}}
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <p class="text-muted small ms-1 mb-0">Belum ada rak di zona ini.
                            <a href="{{ route('master-data.rak.create') }}">Tambah rak</a>
                        </p>
                    @else
                        <p class="text-muted small ms-1 mb-0">Belum ada rak di zona ini.</p>
                    @endif
                    @endif
                </div>
                @empty
                <p class="text-center text-muted py-4 mb-0">Belum ada zona.
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ route('master-data.zona.create') }}">Tambah zona pertama</a>
                    @endif
                </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
