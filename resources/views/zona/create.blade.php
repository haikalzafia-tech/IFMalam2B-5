@extends('layouts.kai')
@section('page_title', 'Tambah Zona')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Zona</h4>
                <a href="{{ route('master-data.zona.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('master-data.zona.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Gudang <span class="text-danger">*</span></label>
                            <select name="gudang_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangs as $g)
                                <option value="{{ $g->id }}" {{ old('gudang_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->kode_gudang }} - {{ $g->nama_gudang }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nama Zona <span class="text-danger">*</span></label>
                            <input type="text" name="nama_zona" class="form-control"
                                value="{{ old('nama_zona') }}" placeholder="Contoh: Zona Elektronik, Zona Bahan Baku" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Jenis Zona <span class="text-danger">*</span></label>
                            <select name="jenis_zona" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="reguler" {{ old('jenis_zona') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="dingin" {{ old('jenis_zona') == 'dingin' ? 'selected' : '' }}>Dingin (Cold Storage)</option>
                                <option value="berbahaya" {{ old('jenis_zona') == 'berbahaya' ? 'selected' : '' }}>Berbahaya (Hazmat)</option>
                                <option value="karantina" {{ old('jenis_zona') == 'karantina' ? 'selected' : '' }}>Karantina</option>
                                <option value="ekspedisi" {{ old('jenis_zona') == 'ekspedisi' ? 'selected' : '' }}>Ekspedisi</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('master-data.zona.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
