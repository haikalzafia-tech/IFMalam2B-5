@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Background Page Bergradien Halus untuk menonjolkan efek Glass */
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

    /* Header Card yang Modern */
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

    /* Wrapper Info Utama dengan Efek Depth */
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

    /* Perbaikan pada x-produk.card-varian (Asumsi struktur component) */
    /* Kita tambahkan wrapper class di sekitar component untuk efek hover */
    .varian-item-wrapper {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 20px;
        overflow: hidden;
    }
    .varian-item-wrapper:hover {
        /* Efek mengangkat dan memiringkan (Tilt) */
        transform: translateY(-15px) rotateX(5deg) rotateY(-3deg);
        box-shadow: 25px 25px 50px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    /* Empty State yang Atraktif */
    .empty-variant-glass {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        border: 2px dashed rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
    }

    /* Responsivitas Mobile */
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
                <div class="info-block-3d">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <x-meta-item label="Nama Produk" value="{{ $produk->nama_produk }}" />
                        </div>
                        <div class="col-md-6">
                            <x-meta-item label="Kategori" value="{{ $produk->kategori->nama_kategori ?? 'Tanpa Kategori' }}" />
                        </div>
                        <div class="col-12">
                            <div class="meta-divider" style="height: 1px; background: #eee; margin: 15px 0;"></div>
                            <x-meta-item label="Deskripsi" value="{{ $produk->deskripsi_produk ?: '-' }}" />
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
                        <h4 class="variant-title m-0">Daftar Varian</h4>
                        <button type="button" class="btn btn-primary btn-round px-4 py-2 shadow" style="background: linear-gradient(135deg, #1d7af3, #6861ce); border: none;" data-bs-toggle="modal"
                            data-bs-target="#modalFormVarian" id="btnTambahVarian">
                            <i class="fas fa-plus me-2"></i> Tambah Varian Baru
                        </button>
                    </div>

                    <div class="variant-grid">
                        @forelse ($produk->varian as $item)
                            <div class="varian-item-wrapper">
                                <x-produk.card-varian :varian="$item" />
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 empty-variant-glass">
                                <i class="fas fa-layer-group fa-4x text-muted mb-3 opacity-25"></i>
                                <h5 class="text-muted fw-bold">Belum ada varian produk.</h5>
                                <p class="text-muted mb-0">Silakan tambahkan varian baru untuk produk ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-produk.form-varian />

@endsection

@push('script')
<script>
$(document).ready(function() {
    let modalEl = $('#modalFormVarian');
    let modal = new bootstrap.Modal(modalEl[0]);
    let $form = $('#modalFormVarian form');

    $("#btnTambahVarian").on('click', function() {
        $form[0].reset();
        $form.find('input[name="_method"]').remove();
        $form.find('small.text-danger').text('');
        $('#modalFormVarian .modal-title').text('Tambah Varian Baru');
        modal.show();
    });

    $(document).on('click', ".btnEditVarian", function() {
        let nama_Varian = $(this).data('nama-varian');
        let harga_varian = $(this).data('harga-varian');
        let stok_varian = $(this).data('stok-varian');
        let action = $(this).data('action');

        $form[0].reset();
        $form.attr('action', action);

        if($form.find('input[name="_method"]').length === 0){
            $form.append('<input type="hidden" name="_method" value="PUT">');
        }

        $form.find('input[name="nama_varian"]').val(nama_Varian);
        $form.find('input[name="harga_varian"]').val(harga_varian);
        $form.find('input[name="stok_varian"]').val(stok_varian);
        $form.find('small.text-danger').text('');
        $('#modalFormVarian .modal-title').text('Edit Varian');
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

    $(document).on('click', ".formDeleteVarian", function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        swal({
            title: "Hapus Varian?",
            text: "Data ini tidak bisa dikembalikan!",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus"],
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
