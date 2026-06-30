@extends('layouts.kai')
@section('page_title', 'Tambah Gudang')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Gudang</h4>
                <a href="{{ route('master-data.gudang.index') }}" class="btn btn-secondary btn-sm">
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
                            <label class="form-label">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_gudang" class="form-control"
                                value="{{ old('nama_gudang') }}" placeholder="Contoh: Gudang Utama Batam" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap gudang" required>{{ old('alamat') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control" value="{{ old('kota') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama PIC <span class="text-danger">*</span></label>
                            <input type="text" name="pic_nama" class="form-control" value="{{ old('pic_nama') }}" placeholder="Penanggung jawab gudang" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon PIC</label>
                            <input type="text" name="pic_telepon" class="form-control" value="{{ old('pic_telepon') }}" placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional">{{ old('keterangan') }}</textarea>
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
