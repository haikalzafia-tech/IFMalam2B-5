@extends('layouts.kai')
@section('page_title', 'Edit Zona')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Zona: {{ $zona->nama_zona }}</h4>
                <a href="{{ route('master-data.zona.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('master-data.zona.update', $zona) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Gudang</label>
                            <input type="text" class="form-control" value="{{ $zona->gudang->nama_gudang }}" disabled>
                            <small class="text-muted">Gudang tidak bisa diubah.</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Nama Zona <span class="text-danger">*</span></label>
                            <input type="text" name="nama_zona" class="form-control @error('nama_zona') is-invalid @enderror"
                                value="{{ old('nama_zona', $zona->nama_zona) }}" required>
                            @error('nama_zona')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jenis Zona <span class="text-danger">*</span></label>
                            <select name="jenis_zona" class="form-select" required>
                                @foreach(['reguler','dingin','berbahaya','karantina','ekspedisi'] as $j)
                                <option value="{{ $j }}" {{ $zona->jenis_zona == $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="aktif" {{ $zona->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $zona->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $zona->keterangan) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.zona.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
