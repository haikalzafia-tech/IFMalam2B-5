@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Background Page Bergradien Halus */
    .page-inner {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        min-height: 100vh;
        padding: 30px;
    }

    /* Container Utama Glassmorphism */
    .detail-container-glass {
        background: rgba(255, 255, 255, 0.6) !important;
        backdrop-filter: blur(15px);
        border-radius: 30px !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden;
    }

    /* Header Card */
    .card-header-glass {
        background: rgba(255, 255, 255, 0.4) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        padding: 25px 30px !important;
    }

    /* Tombol Kembali Floating */
    .btn-back-floating {
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 15px;
        background: #ffffff;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.05), -5px -5px 15px rgba(255,255,255, 0.8);
        color: #1d7af3 !important;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
    }
    .btn-back-floating:hover {
        transform: translateY(-3px) translateX(-5px);
        box-shadow: 8px 8px 20px rgba(0,0,0,0.1);
    }

    /* Wrapper Info Utama */
    .info-block-3d {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
        box-shadow: 15px 15px 30px #d1d9e6, -15px -15px 30px #ffffff;
        position: relative;
    }
    .info-block-3d::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 6px;
        background: linear-gradient(to right, #1d7af3, #6861ce);
        border-radius: 20px 20px 0 0;
    }

    /* Badge Stok Total */
    .stok-total-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        padding: 8px 18px;
        border-radius: 50px;
        box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #ffffff;
        font-weight: 700;
    }

    /* Judul Bagian Varian */
    .variant-title {
        font-weight: 800;
        color: #2a2d34;
        letter-spacing: -1px;
        position: relative;
        display: inline-block;
    }
    .variant-title::after {
        content: '';
        position: absolute;
        bottom: -5px; left: 0; width: 50%; height: 3px;
        background: #6861ce;
        border-radius: 10px;
    }

    /* Grid Layout untuk Varian */
    .variant-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    .varian-item-wrapper {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 20px;
        overflow: hidden;
    }
    .varian-item-wrapper:hover {
        transform: translateY(-15px) rotateX(5deg) rotateY(-3deg);
        box-shadow: 25px 25px 50px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    .empty-variant-glass {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        border: 2px dashed rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
    }

    @media (max-width: 576px) {
        .page-inner { padding: 15px; }
        .detail-container-glass { border-radius: 20px !important; }
        .info-block-3d { padding: 20px; }
        .variant-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container-fluid">
    <div class="page-inner">
        <div class="card detail-container-glass">

            <div class="card-header card-header-glass d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-box-open text-primary fa-2x me-3 opacity-75"></i>
                    <h3 class="fw-bold m-0 text-dark" style="letter-spacing: -0.5px;">{{ $produk->nama_produk }}</h3>
                </div>
                <a href="{{ route('master-data.produk.index') }}" class="btn-back-floating">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card-body p-5">
                <!-- Bagian Informasi Produk -->
                <div class="info-block-3d">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <x-meta-item label="Nama Barang" value="{{ $produk->nama_produk }}" />
                        </div>
                        <div class="col-md-6">
                            <x-meta-item label="Kategori" value="{{ $produk->kategoriProduk->nama_kategori ?? 'Tanpa Kategori' }}" />
                        </div>
                        <div class="col-md-4">
                            <x-meta-item label="Kode Produk" value="{{ $produk->kode_produk }}" />
                        </div>
                        <div class="col-md-4">
                            <x-meta-item label="Merek" value="{{ $produk->merek ?: '-' }}" />
                        </div>
                        <div class="col-md-4">
                            <x-meta-item label="Satuan" value="{{ $produk->satuan }}" />
                        </div>
                        <div class="col-12">
                            <div class="meta-divider" style="height: 1px; background: #eee; margin: 15px 0;"></div>
                            <x-meta-item label="Deskripsi" value="{{ $produk->deskripsi_produk ?: '-' }}" />
                        </div>
                        <div class="col-12">
                            <div class="meta-divider" style="height: 1px; background: #eee; margin: 15px 0;"></div>
                            @php $totalStok = $produk->varianProduks->sum('stok_varian'); @endphp
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="stok-total-badge text-{{ $totalStok < $produk->stok_minimum ? 'danger' : 'success' }}">
                                    <i class="fas fa-cubes"></i> Total Stok: {{ number_format($totalStok) }} {{ $produk->satuan }}
                                </span>
                                <span class="text-muted small">Batas minimum: {{ number_format($produk->stok_minimum) }} {{ $produk->satuan }}</span>
                                @if($totalStok < $produk->stok_minimum)
                                <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i> Di bawah minimum</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Varian -->
                <div class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
                        <h4 class="variant-title m-0">Daftar Varian</h4>

                        {{-- HANYA ADMIN: Tombol Tambah Varian --}}
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <button type="button" class="btn btn-primary btn-round px-4 py-2 shadow"
                                style="background: linear-gradient(135deg, #1d7af3, #6861ce); border: none;"
                                data-bs-toggle="modal"
                                data-bs-target="#modalFormVarian" id="btnTambahVarian">
                                <i class="fas fa-plus me-2"></i> Tambah Varian Baru
                            </button>
                        @endif
                    </div>

                    <div class="variant-grid">
                        @forelse ($produk->varianProduks as $item)
                            <div class="varian-item-wrapper">
                                <x-produk.card-varian :varian="$item" />
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 empty-variant-glass">
                                <i class="fas fa-layer-group fa-4x text-muted mb-3 opacity-25"></i>
                                <h5 class="text-muted fw-bold">Belum ada varian barang.</h5>
                                <p class="text-muted mb-0">Silakan tambahkan varian baru untuk barang ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- HANYA ADMIN: Load Modal Form --}}
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
                    swal({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        buttons: false,
                        timer: 1500,
                        className: "swal-toast-3d",
                    }).then(() => {
                        location.reload();
                    })
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

    // Handler Hapus
    $(document).on('click', ".formDeleteVarian button", function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        swal({
    title: "Hapus Varian?",
    text: "Data ini tidak bisa dikembalikan!",
    icon: "warning",
    buttons: {
        batal: { text: "Batal", value: false, className: "swal-btn-cancel-3d" },
        hapus: { text: "Ya, Hapus", value: true, className: "swal-btn-danger-3d" },
    },
    className: "swal-modal-3d",
    dangerMode: true,

        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
