@extends('layouts.kai')
@section('page_title', 'Tambah Supplier')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Supplier</h4>
                <a href="{{ route('master-data.supplier.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('master-data.supplier.store') }}" method="POST">
                    @csrf

                    <h6 class="text-muted mb-3"><i class="fas fa-building me-1"></i> Informasi Perusahaan</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" class="form-control @error('nama_supplier') is-invalid @enderror"
                                value="{{ old('nama_supplier') }}" required>
                            @error('nama_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jenis Supplier <span class="text-danger">*</span></label>
                            <select name="jenis_supplier" class="form-select @error('jenis_supplier') is-invalid @enderror" required>
                                <option value="">-- Pilih --</option>
                                <option value="produsen" {{ old('jenis_supplier') == 'produsen' ? 'selected' : '' }}>Produsen</option>
                                <option value="distributor" {{ old('jenis_supplier') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                <option value="agen" {{ old('jenis_supplier') == 'agen' ? 'selected' : '' }}>Agen</option>
                                <option value="retailer" {{ old('jenis_supplier') == 'retailer' ? 'selected' : '' }}>Retailer</option>
                            </select>
                            @error('jenis_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" required>{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" value="{{ old('kota') }}" required>
                            @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" value="{{ old('provinsi') }}" required>
                            @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NPWP</label>
                            <input type="text" name="npwp" class="form-control" value="{{ old('npwp') }}" placeholder="Opsional">
                        </div>
                    </div>

                    <h6 class="text-muted mb-3"><i class="fas fa-user me-1"></i> Penanggung Jawab (PIC)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama PIC <span class="text-danger">*</span></label>
                            <input type="text" name="pic_nama" class="form-control @error('pic_nama') is-invalid @enderror" value="{{ old('pic_nama') }}" required>
                            @error('pic_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jabatan PIC</label>
                            <input type="text" name="pic_jabatan" class="form-control" value="{{ old('pic_jabatan') }}" placeholder="Contoh: Sales Manager">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" required>
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.supplier.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
