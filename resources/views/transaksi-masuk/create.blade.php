@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Latar belakang halaman agar efek 3D menonjol */
    .page-inner {
        background: #f1f3f7;
        perspective: 1000px;
    }

    /* Card Utama dengan efek Terapung 3D */
    .card-3d {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border: 1px solid rgba(255,255,255,0.6);
        overflow: hidden;
    }

    .card-3d:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .header-3d {
        background: #1a2035;
        color: #fff;
        padding: 25px;
        border-bottom: 4px solid #f99f2a;
    }

    /* Bagian Form bergaya 'Inset' (Masuk ke dalam) */
    .form-group-3d {
        background: #fbfcfe;
        border-radius: 15px;
        padding: 25px;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e9ecef;
    }

    .label-3d {
        font-weight: 800;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        margin-bottom: 8px;
    }

    /* Input Modern */
    .input-3d, .select2-container--bootstrap-5 .select2-selection {
        border-radius: 10px !important;
        border: 1px solid #ced4da !important;
        padding: 12px 15px !important;
        transition: all 0.3s !important;
        background-color: #f8fafc !important;
    }

    .input-3d:focus {
        border-color: #4e73df !important;
        background-color: #fff !important;
        box-shadow: 0 0 15px rgba(78, 115, 223, 0.2) !important;
        transform: translateY(-1px);
    }

    /* Tombol 'Tambah' 3D */
    .btn-3d-add {
        background: linear-gradient(145deg, #1d253c, #161c2e);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 800;
        width: 100%;
        transition: all 0.2s;
        box-shadow: 0 6px 0 #000;
    }

    .btn-3d-add:active {
        transform: translateY(6px);
        box-shadow: 0 0 0 #000;
    }

    /* Tabel Rapi */
    .table-container-3d {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        background: white;
    }

    .table-3d thead { background: #f8f9fa; }
    .table-3d th { border: none !important; padding: 15px; font-size: 11px; font-weight: 800; color: #6c757d; }
    .table-3d td { padding: 15px; vertical-align: middle; }

    /* Perapian kolom Angka */
    .text-end-custom { text-align: right !important; padding-right: 25px !important; }

    /* Box Grand Total */
    .total-box-3d {
        background: #1a2035;
        color: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 10px 10px 25px rgba(0,0,0,0.1);
        border-left: 6px solid #f99f2a;
    }

    .btn-3d-save {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 40px;
        font-weight: 800;
        color: white;
        box-shadow: 0 10px 20px rgba(78, 115, 223, 0.3);
        transition: 0.3s;
    }

    @media (max-width: 768px) {
        .row > div { margin-bottom: 15px; }
        .total-box-3d { width: 100%; text-align: center; }
    }
</style>

<div class="card card-3d">
    <div class="header-3d">
        <h4 class="mb-0 fw-bold"><i class="fas fa-file-download me-2"></i> Transaksi Barang Masuk</h4>
    </div>

    <div class="card-body p-4 p-md-5">
        <form id="form-add-produk">
            <div class="form-group-3d mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <label class="label-3d">Nama Pengirim</label>
                        <input type="text" id="pengirim" class="form-control input-3d" placeholder="PT. Nama Pengirim">
                    </div>
                    <div class="col-md-4">
                        <label class="label-3d">Kontak / HP</label>
                        <input type="text" id="kontak" class="form-control input-3d" placeholder="0812xxxx">
                    </div>
                    <div class="col-md-4">
                        <label class="label-3d">Keterangan</label>
                        <input type="text" id="keterangan" class="form-control input-3d" placeholder="Opsional...">
                    </div>
                </div>
            </div>

            <h6 class="fw-bold mb-3">Pilih Item Barang</h6>
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="label-3d">Barang</label>
                    <select id="select-produk" class="form-control w-100 input-3d"></select>
                </div>
                <div class="col-lg-2 col-6">
                    <label class="label-3d">No. Batch</label>
                    <input type="text" id="nomor_batch" class="form-control input-3d" placeholder="BATCH-01">
                </div>
                <div class="col-lg-1 col-6">
                    <label class="label-3d">Qty</label>
                    <input type="number" id="qty" class="form-control input-3d" placeholder="0">
                </div>
                <div class="col-lg-3">
                    <label class="label-3d">Harga Satuan (Rp)</label>
                    <input type="number" id="harga" class="form-control input-3d" placeholder="0">
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn-3d-add">TAMBAH</button>
                </div>
            </div>
        </form>

        <div class="table-container-3d mt-5">
            <div class="table-responsive">
                <table class="table table-hover table-3d mb-0" id="table-produk">
                    <thead>
                        <tr class="text-center">
                            <th width="50">NO</th>
                            <th class="text-start">BARANG</th>
                            <th>BATCH</th>
                            <th>QTY</th>
                            <th class="text-end-custom">HARGA</th>
                            <th class="text-end-custom">SUB TOTAL</th>
                            <th width="80">AKSI</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="row mt-5 align-items-center">
            <div class="col-md-6 order-2 order-md-1">
                <form id="form-transaksi">
                    <button type="submit" class="btn-3d-save">
                        <i class="fas fa-save me-2"></i> SIMPAN TRANSAKSI
                    </button>
                </form>
            </div>
            <div class="col-md-6 order-1 order-md-2 d-flex justify-content-md-end mb-4 mb-md-0">
                <div class="total-box-3d">
                    <span class="small opacity-75 d-block fw-bold mb-1">GRAND TOTAL</span>
                    <h2 class="mb-0 fw-bold text-warning">Rp <span id="grand-total">0</span></h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
$(document).ready(function() {
    $("#alert-danger").hide();
    const numberFormat = new Intl.NumberFormat('id-ID')
    let selectedOption = {};
    let selectedProduk = [];

    $('#select-produk').select2({
        placeholder: 'Pilih Barang',
        delay: 250,
        allowClear: true,
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('get-data.varian-produk') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { search: params.term };
            },
            processResults: function(data) {
                return {
                    results: data.map((item) => {
                        return { id: item.id, text: item.text, nomor_sku: item.nomor_sku }
                    })
                }
            }
        }
    })

    $('#select-produk').on('select2:select', function(e) {
        selectedOption = e.params.data;
    })

    $("#form-add-produk").on("submit", function(e) {
        e.preventDefault();
        let qty = parseInt($("#qty").val());
        let harga = parseInt($("#harga").val());
        let nomor_batch = $("#nomor_batch").val();

        if (!selectedOption.id || !qty || !harga || !nomor_batch) {
            swal({ icon: 'warning', title: 'Perhatian', text: 'Input Belum Lengkap' });
            return;
        }

        let existingItem = selectedProduk.find(item => item.nomor_sku === selectedOption.nomor_sku);
        if (existingItem) {
            existingItem.qty = parseInt(existingItem.qty) + parseInt(qty);
            existingItem.subTotal = existingItem.qty * existingItem.harga;
        } else {
            selectedProduk.push({
                text: selectedOption.text,
                nomor_sku: selectedOption.nomor_sku,
                qty: qty,
                harga: harga,
                nomor_batch: nomor_batch,
                subTotal: qty * harga,
            })
        }

        $("#select-produk").val(null).trigger('change');
        $("#qty, #harga, #nomor_batch").val('');
        renderTable();
    });

    function renderTable() {
        let tableBody = $("#table-produk tbody");
        tableBody.empty();

        if (selectedProduk.length === 0) {
            tableBody.append(`<tr><td colspan="7" class="text-center py-5 text-muted fw-bold">Belum ada data barang</td></tr>`);
        } else {
            selectedProduk.forEach((item, index) => {
                tableBody.append(`
                    <tr class="text-center">
                        <td>${index + 1}</td>
                        <td class="text-start fw-bold text-dark">${item.text}</td>
                        <td><span class="badge bg-light text-dark border">${item.nomor_batch}</span></td>
                        <td><span class="badge bg-primary px-3 rounded-pill">${item.qty}</span></td>
                        <td class="text-end-custom font-monospace">${numberFormat.format(item.harga)}</td>
                        <td class="text-end-custom fw-bold text-primary fs-6 font-monospace">${numberFormat.format(item.subTotal)}</td>
                        <td>
                            <button class="btn btn-link text-danger btn-delete" data-nomor-sku="${item.nomor_sku}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        let grandTotal = selectedProduk.reduce((total, item) => total + item.subTotal, 0);
        $("#grand-total").text(numberFormat.format(grandTotal));
    }

    $(document).on("click", ".btn-delete", function() {
        let nomorSku = $(this).data('nomor-sku');
        selectedProduk = selectedProduk.filter(item => item.nomor_sku !== nomorSku);
        renderTable();
    });

    $("#form-transaksi").on("submit", function(e) {
        e.preventDefault();
        if (selectedProduk.length === 0) {
            swal({ icon: 'error', title: 'Oops!', text: 'Wajib mengisi minimal 1 barang' });
            return;
        }

        $.ajax({
            method: "POST",
            url: "{{ route('transaksi-masuk.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                items: selectedProduk,
                pengirim: $("#pengirim").val(),
                kontak: $("#kontak").val(),
                keterangan: $("#keterangan").val(),
            },
            success: function(response) {
                if (response.success) window.location.href = response.redirect_url;
            }
        });
    });
    renderTable();
});
</script>
@endpush
