@extends('layouts.kai')
@section('page_title', 'Tambah Rak')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Rak</h4>
                <a href="{{ route('master-data.rak.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('master-data.rak.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Zona <span class="text-danger">*</span></label>
                            <select name="zona_id" class="form-select" required>
                                <option value="">-- Pilih Zona --</option>
                                @foreach($zonas as $z)
                                <option value="{{ $z->id }}" {{ old('zona_id') == $z->id ? 'selected' : '' }}>
                                    {{ $z->gudang->nama_gudang }} &raquo; {{ $z->kode_zona }} - {{ $z->nama_zona }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nama Rak <span class="text-danger">*</span></label>
                            <input type="text" name="nama_rak" class="form-control"
                                value="{{ old('nama_rak') }}" placeholder="Contoh: Rak A1, Rak Besi Besar" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Baris <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_baris" class="form-control" value="{{ old('jumlah_baris', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Kolom <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_kolom" class="form-control" value="{{ old('jumlah_kolom', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Kapasitas Total (unit) <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas_total" class="form-control" value="{{ old('kapasitas_total') }}" min="1" placeholder="Contoh: 100" required>
                            <small class="text-muted">Total unit/barang yang bisa ditampung di rak ini</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.rak.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
