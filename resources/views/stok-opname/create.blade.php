@extends('layouts.kai')
@section('page_title', 'Buat Pemeriksaan Fisik Persediaan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Pemeriksaan Fisik Persediaan Baru</h4>
                <a href="{{ route('stok-opname.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Setelah dibuat, sistem akan otomatis menampilkan semua barang di gudang ini beserta stok sistemnya.
                    Anda tinggal mengisi stok fisik hasil hitung manual.
                </div>

                <form action="{{ route('stok-opname.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Gudang <span class="text-danger">*</span></label>
                            <select name="gudang_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tanggal Fisik Persediaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_opname" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-play me-1"></i> Mulai Fisik Persediaan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('stok-opname.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
