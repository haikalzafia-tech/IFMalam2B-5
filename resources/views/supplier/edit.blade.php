@extends('layouts.kai')
@section('page_title', 'Edit Supplier')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Supplier: {{ $supplier->nama_supplier }}</h4>
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

                <form action="{{ route('master-data.supplier.update', $supplier) }}" method="POST">
                    @csrf @method('PUT')

                    <h6 class="text-muted mb-3"><i class="fas fa-building me-1"></i> Informasi Perusahaan</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" class="form-control" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jenis Supplier <span class="text-danger">*</span></label>
                            <select name="jenis_supplier" class="form-select" required>
                                @foreach(['produsen','distributor','agen','retailer'] as $j)
                                <option value="{{ $j }}" {{ $supplier->jenis_supplier == $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control" value="{{ old('kota', $supplier->kota) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $supplier->provinsi) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $supplier->kode_pos) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NPWP</label>
                            <input type="text" name="npwp" class="form-control" value="{{ old('npwp', $supplier->npwp) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="aktif" {{ $supplier->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $supplier->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="text-muted mb-3"><i class="fas fa-user me-1"></i> Penanggung Jawab (PIC)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama PIC <span class="text-danger">*</span></label>
                            <input type="text" name="pic_nama" class="form-control" value="{{ old('pic_nama', $supplier->pic_nama) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jabatan PIC</label>
                            <input type="text" name="pic_jabatan" class="form-control" value="{{ old('pic_jabatan', $supplier->pic_jabatan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $supplier->telepon) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $supplier->keterangan) }}</textarea>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.supplier.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
