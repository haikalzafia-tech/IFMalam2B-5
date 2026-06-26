@extends('layouts.kai')
@section('page_title', 'Tambah Gudang')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Gudang</h4>
                <a href="{{ route('master-data.gudang.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('master-data.gudang.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_gudang" class="form-control @error('nama_gudang') is-invalid @enderror"
                                value="{{ old('nama_gudang') }}" placeholder="Contoh: Gudang Utama Batam" required>
                            @error('nama_gudang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                rows="2" placeholder="Alamat lengkap gudang" required>{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                                value="{{ old('kota') }}" required>
                            @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror"
                                value="{{ old('provinsi') }}" required>
                            @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama PIC <span class="text-danger">*</span></label>
                            <input type="text" name="pic_nama" class="form-control @error('pic_nama') is-invalid @enderror"
                                value="{{ old('pic_nama') }}" placeholder="Penanggung jawab gudang" required>
                            @error('pic_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telepon PIC</label>
                            <input type="text" name="pic_telepon" class="form-control"
                                value="{{ old('pic_telepon') }}" placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"
                                placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.gudang.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
