@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-box-open" style="color: var(--sigma-navy-500)"></i>
            <h4 class="card-title mb-0">{{ $produk->nama_produk }}</h4>
        </div>
        <a href="{{ route('master-data.produk.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted d-block">Kategori</small>
                <span class="fw-semibold">{{ $produk->kategoriProduk->nama_kategori ?? 'Tanpa Kategori' }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Kode Produk</small>
                <span class="fw-semibold">{{ $produk->kode_produk }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Satuan</small>
                <span class="fw-semibold">{{ $produk->satuan }}</span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Merek</small>
                <span class="fw-semibold">{{ $produk->merek ?: '-' }}</span>
            </div>
            <div class="col-12">
                <hr class="my-2" style="border-color: var(--sigma-border)">
                <small class="text-muted d-block mb-1">Deskripsi</small>
                <p class="mb-0">{{ $produk->deskripsi_produk ?: '-' }}</p>
            </div>
            <div class="col-12">
                <hr class="my-2" style="border-color: var(--sigma-border)">
                @php $totalStok = $produk->varianProduks->sum('stok_varian'); @endphp
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span class="badge bg-{{ $totalStok < $produk->stok_minimum ? 'danger' : 'success' }}" style="font-size: 13px; padding: 8px 16px;">
                        <i class="fas fa-cubes me-1"></i> Total Stok: {{ number_format($totalStok) }} {{ $produk->satuan }}
                    </span>
                    <span class="text-muted small">Batas minimum: {{ number_format($produk->stok_minimum) }} {{ $produk->satuan }}</span>
                    @if($totalStok < $produk->stok_minimum)
                    <span class="badge bg-warning"><i class="fas fa-exclamation-triangle me-1"></i> Di bawah minimum</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Daftar Varian</h4>
        @if(Auth::check() && Auth::user()->role === 'admin')
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormVarian" id="btnTambahVarian">
                <i class="fas fa-plus me-1"></i> Tambah Varian
            </button>
        @endif
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse ($produk->varianProduks as $item)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <x-produk.card-varian :varian="$item" />
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-layer-group fa-2x text-muted mb-2 d-block opacity-50"></i>
                    <p class="text-muted mb-0">Belum ada varian barang.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@if(Auth::check() && Auth::user()->role === 'admin')
    <x-produk.form-varian :raks="$raks" :produk_id="$produk->id" />
@endif

@endsection

@push('script')
<script>
$(document).ready(function() {
    let modalEl = $('#modalFormVarian');
    if (modalEl.length > 0) {
        let modal = new bootstrap.Modal(modalEl[0]);
        let $form = $('#modalFormVarian form');
        let defaultAction = $form.attr('action');

        $("#btnTambahVarian").on('click', function() {
            $form[0].reset();
            $form.attr('action', defaultAction);
            $form.find('input[name="_method"]').remove();
            $form.find('small.text-danger').text('');
            $('#modalFormVarianLabel').text('Tambah Varian Baru');
            modal.show();
        });

        $(document).on('click', ".btnEditVarian", function() {
            let namaVarian = $(this).data('nama-varian');
            let rakId = $(this).data('rak-id');
            let stokVarian = $(this).data('stok-varian');
            let berat = $(this).data('berat');
            let dimensi = $(this).data('dimensi');
            let action = $(this).data('action');

            $form[0].reset();
            $form.attr('action', action);

            if($form.find('input[name="_method"]').length === 0){
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.find('select[name="rak_id"]').val(rakId);
            $form.find('input[name="nama_varian"]').val(namaVarian);
            $form.find('input[name="stok_varian"]').val(stokVarian);
            $form.find('input[name="berat"]').val(berat);
            $form.find('input[name="dimensi"]').val(dimensi);
            $form.find('small.text-danger').text('');
            $('#modalFormVarianLabel').text('Edit Varian');
            modal.show();
        });

        $form.submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    SigmaNotif.sukses(response.message);
                    setTimeout(() => location.reload(), 1200);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    $form.find('small.text-danger').text('');
                    $.each(errors, function(key, val) {
                        $form.find('[name="' + key + '"]').next('small.text-danger').text(val[0]);
                    })
                }
            });
        });
    }

    $(document).on('click', ".formDeleteVarian button", function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        SigmaNotif.konfirmasi({
            judul: 'Hapus Varian?',
            teks: 'Data ini tidak bisa dikembalikan!',
            icon: 'warning',
        }, function() {
            form.submit();
        });
    });
});
</script>
@endpush
