@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Card Utama - Mengikuti image_f3da37.png */
    .card-3d {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        background: #fff;
    }

    .header-3d {
        background: #1a2035;
        color: #fff;
        padding: 20px 25px;
        border-bottom: 5px solid #e91e63; /* Accent Keluar */
    }

    /* Group Form Identitas - Efek Inset seperti di gambar */
    .form-identitas-wrapper {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 35px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    .label-custom {
        font-weight: 800;
        color: #4a5568;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: block;
    }

    .input-3d {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 12px 15px !important;
        background: #f8fafc !important;
        transition: all 0.3s;
    }

    /* Tombol Tambah - Mengikuti desain solid di image_f3da37.png */
    .btn-tambah-solid {
        background: #1a2035;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 800;
        text-transform: uppercase;
        width: 100%;
        letter-spacing: 1px;
    }

    /* Styling Tabel - Mengikuti image_f3da37.png */
    .table-wrapper {
        border: 1px solid #edf2f7;
        border-radius: 12px;
        overflow: hidden;
        margin-top: 20px;
    }

    .table-custom thead {
        background: #f8fafc;
    }

    .table-custom th {
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 800;
        color: #718096;
        padding: 15px !important;
        border: none !important;
    }

    /* Footer Section */
    .btn-simpan-custom {
        background: #3b5bdb;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 15px 35px;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(59, 91, 219, 0.3);
    }

    .grand-total-box {
        background: #1a2035;
        color: #fff;
        padding: 20px 30px;
        border-radius: 15px;
        border-left: 5px solid #ff9800;
        min-width: 280px;
    }
</style>

<div class="card card-3d">
    <div class="header-3d d-flex align-items-center">
        <i class="fas fa-shipping-fast fa-lg me-3"></i>
        <h4 class="mb-0 fw-bold">Transaksi Barang Keluar</h4>
    </div>

    <div class="card-body p-4 p-md-5">
        <div class="alert alert-danger" id="alert-danger" style="display:none; border-radius:10px;"></div>

        <!-- Bagian 1: Identitas Penerima (Mengikuti Row 1 di Gambar) -->
        <div class="form-identitas-wrapper">
            <div class="row g-4 text-start">
                <div class="col-md-4">
                    <label class="label-custom">Nama Penerima</label>
                    <input type="text" id="penerima" class="form-control input-3d" placeholder="Nama Penerima...">
                </div>
                <div class="col-md-4">
                    <label class="label-custom">Kontak / HP</label>
                    <input type="text" id="kontak" class="form-control input-3d" placeholder="0812xxxx">
                </div>
                <div class="col-md-4">
                    <label class="label-custom">Keterangan</label>
                    <input type="text" id="keterangan" class="form-control input-3d" placeholder="Opsional (Contoh: Urgent)">
                </div>
            </div>
        </div>

        <!-- Bagian 2: Input Item -->
        <div class="mb-4">
            <h6 class="fw-bold d-flex align-items-center text-primary mb-3">
                <i class="fas fa-plus-circle me-2"></i> Input Item Barang
            </h6>
            <form id="form-add-produk">
                <div class="row g-3 align-items-end text-start">
                    <div class="col-lg-3">
                        <label class="label-custom">Pilih Barang</label>
                        <select id="select-produk" class="form-control input-3d w-100"></select>
                    </div>
                    <div class="col-lg-2">
                        <label class="label-custom">Stok Tersedia</label>
                        <input type="number" id="stok" class="form-control input-3d" readonly placeholder="0">
                    </div>
                    <div class="col-lg-2">
                        <label class="label-custom">Jumlah Keluar</label>
                        <input type="number" id="qty" class="form-control input-3d" placeholder="0">
                    </div>
                    <div class="col-lg-2">
                        <label class="label-custom">Harga Satuan (Rp)</label>
                        <input type="number" id="harga" class="form-control input-3d" readonly placeholder="0">
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn-tambah-solid">TAMBAH</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabel Item (Sesuai image_f3da37.png) -->
        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-hover table-custom mb-0" id="table-produk">
                    <thead class="text-center">
                        <tr>
                            <th width="50">NO</th>
                            <th class="text-start">NAMA BARANG</th>
                            <th>QTY</th>
                            <th class="text-end">HARGA SATUAN</th>
                            <th class="text-end">SUB TOTAL</th>
                            <th width="100">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <tr id="empty-row">
                            <td colspan="6" class="text-center py-5 text-muted font-italic">
                                Belum ada barang yang ditambahkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer: Simpan & Grand Total -->
        <div class="row mt-5 align-items-center">
            <div class="col-md-6 text-start">
                <button type="button" id="btn-simpan-transaksi" class="btn-simpan-custom">
                    <i class="fas fa-save me-2"></i> SIMPAN TRANSAKSI
                </button>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-4 mt-md-0">
                <div class="grand-total-box text-start">
                    <span class="small opacity-75 fw-bold d-block mb-1">GRAND TOTAL</span>
                    <h2 class="mb-0 fw-bold" style="color: #ff9800;">Rp <span id="grand-total">0</span></h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
// Script Anda tetap berfungsi dengan ID yang sudah disesuaikan di atas
$(document).ready(function() {
    const numberFormat = new Intl.NumberFormat('id-ID');
    let selectedProduk = [];
    let currentData = null;

    $('#select-produk').select2({
        placeholder: 'Pilih Barang...',
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('get-data.varian-produk') }}",
            dataType: 'json',
            delay: 250,
            data: params => ({ search: params.term }),
            processResults: data => ({
                results: data.map(item => ({
                    id: item.id,
                    text: item.text,
                    harga: item.harga,
                    stok: item.stok,
                    nomor_sku: item.nomor_sku
                }))
            })
        }
    });

    $('#select-produk').on('select2:select', function(e) {
        currentData = e.params.data;
        $('#harga').val(currentData.harga);
        $('#stok').val(currentData.stok);
    });

    $("#form-add-produk").on("submit", function(e) {
        e.preventDefault();
        let qty = parseInt($("#qty").val());
        let stok = parseInt($("#stok").val());

        if (!currentData || isNaN(qty) || qty <= 0) {
            swal("Perhatian", "Lengkapi input barang dan jumlah!", "warning");
            return;
        }

        if (qty > stok) {
            swal("Stok Kurang", "Stok tersedia hanya " + stok, "error");
            return;
        }

        let existing = selectedProduk.find(i => i.nomor_sku === currentData.nomor_sku);
        if (existing) {
            if ((existing.qty + qty) > stok) {
                swal("Stok Kurang", "Total qty melebihi stok!", "error");
                return;
            }
            existing.qty += qty;
            existing.subTotal = existing.qty * existing.harga;
        } else {
            selectedProduk.push({
                text: currentData.text,
                nomor_sku: currentData.nomor_sku,
                qty: qty,
                harga: currentData.harga,
                subTotal: qty * currentData.harga
            });
        }

        $("#qty").val('');
        $('#select-produk').val(null).trigger('change');
        $('#harga, #stok').val('');
        currentData = null;
        renderTable();
    });

    function renderTable() {
        let html = "";
        let grandTotal = 0;

        if (selectedProduk.length === 0) {
            html = `<tr><td colspan="6" class="text-center py-5 text-muted font-italic">Belum ada barang yang ditambahkan.</td></tr>`;
        } else {
            selectedProduk.forEach((item, index) => {
                grandTotal += item.subTotal;
                html += `
                    <tr class="text-center">
                        <td>${index + 1}</td>
                        <td class="text-start fw-bold">${item.text}</td>
                        <td><span class="badge bg-secondary px-3">${item.qty}</span></td>
                        <td class="text-end">${numberFormat.format(item.harga)}</td>
                        <td class="text-end fw-bold">${numberFormat.format(item.subTotal)}</td>
                        <td>
                            <button class="btn btn-link text-danger btn-delete" data-sku="${item.nomor_sku}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
            });
        }
        $("#table-produk tbody").html(html);
        $("#grand-total").text(numberFormat.format(grandTotal));
    }

    $(document).on("click", ".btn-delete", function() {
        let sku = $(this).data('sku');
        selectedProduk = selectedProduk.filter(i => i.nomor_sku !== sku);
        renderTable();
    });

    $("#btn-simpan-transaksi").on("click", function() {
        if (selectedProduk.length === 0) {
            swal("Kosong", "Pilih minimal satu barang!", "warning");
            return;
        }

        $.ajax({
            url: "{{ route('transaksi-keluar.store') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                penerima: $("#penerima").val(),
                kontak: $("#kontak").val(),
                keterangan: $("#keterangan").val(),
                items: selectedProduk
            },
            success: res => res.success && (window.location.href = res.redirect_url),
            error: xhr => {
                $("#alert-danger").empty().show().append(`<p class="mb-0 small">${xhr.responseJSON.message}</p>`);
            }
        });
    });
});
</script>
@endpush
