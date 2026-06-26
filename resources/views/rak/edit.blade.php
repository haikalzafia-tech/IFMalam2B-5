@extends('layouts.kai')
@section('page_title', 'Edit Rak')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Rak: {{ $rak->nama_rak }}</h4>
                <a href="{{ route('master-data.rak.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('master-data.rak.update', $rak) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Zona</label>
                            <input type="text" class="form-control" value="{{ $rak->zona->gudang->nama_gudang }} › {{ $rak->zona->nama_zona }}" disabled>
                            <small class="text-muted">Zona tidak bisa diubah.</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Nama Rak <span class="text-danger">*</span></label>
                            <input type="text" name="nama_rak" class="form-control" value="{{ old('nama_rak', $rak->nama_rak) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jumlah Baris <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_baris" class="form-control" value="{{ old('jumlah_baris', $rak->jumlah_baris) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jumlah Kolom <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_kolom" class="form-control" value="{{ old('jumlah_kolom', $rak->jumlah_kolom) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kapasitas Total <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas_total" class="form-control" value="{{ old('kapasitas_total', $rak->kapasitas_total) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="aktif" {{ $rak->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="penuh" {{ $rak->status == 'penuh' ? 'selected' : '' }}>Penuh</option>
                                <option value="nonaktif" {{ $rak->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $rak->keterangan) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.rak.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
