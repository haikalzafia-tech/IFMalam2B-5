@extends('layouts.kai')
@section('page_title', 'Detail Gudang')

@section('content')
<div class="row">
    {{-- Info Gudang --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Gudang</h4>
                <a href="{{ route('master-data.gudang.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">Kode</td><td><span class="badge bg-secondary">{{ $gudang->kode_gudang }}</span></td></tr>
                    <tr><td class="text-muted">Nama</td><td><strong>{{ $gudang->nama_gudang }}</strong></td></tr>
                    <tr><td class="text-muted">Alamat</td><td>{{ $gudang->alamat }}</td></tr>
                    <tr><td class="text-muted">Kota</td><td>{{ $gudang->kota }}, {{ $gudang->provinsi }}</td></tr>
                    <tr><td class="text-muted">PIC</td><td>{{ $gudang->pic_nama }}</td></tr>
                    <tr><td class="text-muted">Telepon</td><td>{{ $gudang->pic_telepon ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge bg-{{ $gudang->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($gudang->status) }}</span></td>
                    </tr>
                </table>
                <a href="{{ route('master-data.gudang.edit', $gudang) }}" class="btn btn-warning btn-sm w-100 mt-2">
                    <i class="fas fa-edit me-1"></i> Edit Gudang
                </a>
            </div>
        </div>

        {{-- Kapasitas Gudang --}}
        <div class="card mt-3">
            <div class="card-header"><h4 class="card-title">Kapasitas Gudang</h4></div>
            <div class="card-body text-center">
                <h2 class="text-{{ $persentase >= 90 ? 'danger' : ($persentase >= 70 ? 'warning' : 'success') }}">
                    {{ $persentase }}%
                </h2>
                <p class="text-muted mb-1">Terpakai</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-{{ $persentase >= 90 ? 'danger' : ($persentase >= 70 ? 'warning' : 'success') }}"
                        style="width: {{ $persentase }}%"></div>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <h5>{{ number_format($totalTerpakai) }}</h5>
                        <small class="text-muted">Terpakai</small>
                    </div>
                    <div class="col-6">
                        <h5>{{ number_format($totalKapasitas) }}</h5>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Zona & Rak --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Layout Zona & Rak</h4>
                <a href="{{ route('master-data.zona.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Zona
                </a>
            </div>
            <div class="card-body">
                @forelse($gudang->zonas as $zona)
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">
                            <span class="badge bg-primary me-2">{{ $zona->kode_zona }}</span>
                            {{ $zona->nama_zona }}
                            <small class="text-muted ms-1">({{ ucfirst($zona->jenis_zona) }})</small>
                        </h5>
                        <span class="badge bg-{{ $zona->status == 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($zona->status) }}</span>
                    </div>

                    @if($zona->raks->count() > 0)
                    <div class="row g-2">
                        @foreach($zona->raks as $rak)
                        @php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; @endphp
                        <div class="col-md-4">
                            <div class="card border {{ $persen >= 90 ? 'border-danger' : ($persen >= 70 ? 'border-warning' : 'border-success') }}">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $rak->kode_rak }}</strong>
                                        <span class="badge bg-{{ $rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($rak->status) }}
                                        </span>
                                    </div>
                                    <small class="text-muted d-block">{{ $rak->nama_rak }}</small>
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar bg-{{ $persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success') }}"
                                            style="width: {{ $persen }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $rak->kapasitas_terpakai }}/{{ $rak->kapasitas_total }} ({{ $persen }}%)</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted small ms-2">Belum ada rak di zona ini.
                        <a href="{{ route('master-data.rak.create') }}">Tambah rak</a>
                    </p>
                    @endif
                </div>
                @if(!$loop->last)<hr>@endif
                @empty
                <p class="text-center text-muted">Belum ada zona. <a href="{{ route('master-data.zona.create') }}">Tambah zona pertama</a></p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
