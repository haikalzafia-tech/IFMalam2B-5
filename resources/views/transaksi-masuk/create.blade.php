@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    /* Latar belakang & Efek 3D */
    .page-inner {
        background: #f1f3f7;
        perspective: 1000px;
    }

    .card-3d {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        transition: transform 0.4s ease;
        border: 1px solid rgba(255,255,255,0.6);
        overflow: hidden;
    }

    .header-3d {
        background: #1a2035;
        color: #fff;
        padding: 25px;
        border-bottom: 4px solid #f99f2a;
    }

    /* Form Styling */
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
        font-size: 0.72rem;
        margin-bottom: 8px;
        display: block;
    }

    .input-3d {
        border-radius: 10px !important;
        border: 1px solid #ced4da !important;
        padding: 12px 15px !important;
        background-color: #f8fafc !important;
        transition: all 0.3s;
    }

    .input-3d:focus {
        border-color: #4e73df !important;
        background-color: #fff !important;
        box-shadow: 0 0 12px rgba(78, 115, 223, 0.15) !important;
    }

    /* Tombol-tombol */
    .btn-3d-add {
        background: linear-gradient(145deg, #1d253c, #161c2e);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 800;
        width: 100%;
        box-shadow: 0 4px 0 #000;
        transition: all 0.1s;
    }

    .btn-3d-add:active {
        transform: translateY(4px);
        box-shadow: 0 0 0 #000;
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

    .btn-3d-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(78, 115, 223, 0.4);
        color: white;
    }

    /* Tabel Styling */
    .table-container-3d {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        background: white;
    }

    .table-3d thead th {
        background: #f8f9fa;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 15px;
        border: none;
    }

    /* Summary Box */
    .total-box-3d {
        background: #1a2035;
        color: #fff;
        padding: 20px 30px;
        border-radius: 15px;
        border-left: 6px solid #f99f2a;
        min-width: 280px;
    }

    .font-mono { font-family: 'Courier New', Courier, monospace; }
</style>

<div class="card card-3d">
    <div class="header-3d">
        <h4 class="mb-0 fw-bold"><i class="fas fa-truck-loading me-2"></i> Transaksi Barang Masuk</h4>
    </div>

    <div class="card-body p-4 p-md-5">
        <!-- Section: Data Header -->
        <div class="form-group-3d mb-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="label-3d">Nama Pengirim</label>
                    <input type="text" id="pengirim" class="form-control input-3d" placeholder="PT. Nama Supplier">
                </div>
                <div class="col-md-4">
                    <label class="label-3d">Kontak / HP</label>
                    <input type="text" id="kontak" class="form-control input-3d" placeholder="0812xxxx">
                </div>
                <div class="col-md-4">
                    <label class="label-3d">Keterangan</label>
                    <input type="text" id="keterangan" class="form-control input-3d" placeholder="Opsional (Contoh: Urgent)">
                </div>
            </div>
        </div>

        <!-- Section: Input Item -->
        <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-1"></i> Input Item Barang</h6>
        <form id="form-add-produk" class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="label-3d">Pilih Barang</label>
                <select id="select-produk" class="form-control w-100"></select>
            </div>
            <div class="col-lg-2">
                <label class="label-3d">Nomor Batch</label>
                <input type="text" id="nomor_batch" class="form-control input-3d" placeholder="BCH-001">
            </div>
            <div class="col-lg-2">
                <label class="label-3d">Jumlah Barang</label>
                <input type="number" id="qty" class="form-control input-3d" placeholder="0" min="1">
            </div>
            <div class="col-lg-2">
                <label class="label-3d">Harga Satuan (Rp)</label>
                <input type="number" id="harga" class="form-control input-3d" placeholder="0">
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn-3d-add">TAMBAH</button>
            </div>
        </form>

        <!-- Section: Tabel List -->
        <div class="table-container-3d mt-5">
            <div class="table-responsive">
                <table class="table table-hover table-3d mb-0" id="table-produk">
                    <thead>
                        <tr class="text-center">
                            <th width="60">NO</th>
                            <th class="text-start">NAMA BARANG</th>
                            <th>BATCH</th>
                            <th>JUMLAH</th>
                            <th class="text-end">HARGA SATUAN</th>
                            <th class="text-end">SUB TOTAL</th>
                            <th width="80">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data diisi via JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section: Footer & Simpan -->
        <div class="row mt-5 align-items-center">
            <div class="col-md-6 order-2 order-md-1">
                <button type="button" id="btn-save-transaksi" class="btn-3d-save">
                    <i class="fas fa-save me-2"></i> SIMPAN TRANSAKSI
                </button>
            </div>
            <div class="col-md-6 order-1 order-md-2 d-flex justify-content-md-end mb-4 mb-md-0">
                <div class="total-box-3d">
                    <span class="small opacity-75 d-block fw-bold mb-1">GRAND TOTAL</span>
                    <h2 class="mb-0 fw-bold text-warning font-mono">Rp <span id="grand-total">0</span></h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
$(document).ready(function() {
    const numberFormat = new Intl.NumberFormat('id-ID');
    let selectedOption = {};
    let selectedProduk = [];

    // 1. Inisialisasi Select2 Modern
    $('#select-produk').select2({
        placeholder: 'Pilih Barang...',
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('get-data.varian-produk') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) { return { search: params.term }; },
            processResults: function(data) {
                return {
                    results: data.map((item) => ({
                        id: item.id,
                        text: item.text,
                        nomor_sku: item.nomor_sku
                    }))
                }
            }
        }
    });

    $('#select-produk').on('select2:select', function(e) {
        selectedOption = e.params.data;
    });

    // 2. Logika Tambah Item ke Array & Tabel
    $("#form-add-produk").on("submit", function(e) {
        e.preventDefault();

        let qty = parseInt($("#qty").val()) || 0;
        let harga = parseInt($("#harga").val()) || 0;
        let batch = $("#nomor_batch").val().trim().toUpperCase();

        if (!selectedOption.id || qty <= 0 || harga <= 0 || batch === "") {
            swal({ icon: 'warning', title: 'Data Tidak Lengkap', text: 'Harap isi Barang, Batch, Jumlah, dan Harga!' });
            return;
        }

        // Cek jika barang & batch yang sama sudah diinput
        let existingItem = selectedProduk.find(item =>
            item.nomor_sku === selectedOption.nomor_sku && item.nomor_batch === batch
        );

        if (existingItem) {
            existingItem.qty += qty;
            existingItem.subTotal = existingItem.qty * existingItem.harga;
        } else {
            selectedProduk.push({
                text: selectedOption.text,
                nomor_sku: selectedOption.nomor_sku,
                qty: qty,
                harga: harga,
                nomor_batch: batch,
                subTotal: qty * harga,
            });
        }

        // Reset Input Form
        $("#select-produk").val(null).trigger('change');
        $("#qty, #harga, #nomor_batch").val('');
        selectedOption = {};
        renderTable();
    });

    // 3. Render Tabel HTML
    function renderTable() {
        let tableBody = $("#table-produk tbody");
        tableBody.empty();

        if (selectedProduk.length === 0) {
            tableBody.append(`<tr><td colspan="7" class="text-center py-5 text-muted fw-bold">Belum ada barang yang ditambahkan.</td></tr>`);
        } else {
            selectedProduk.forEach((item, index) => {
                tableBody.append(`
                    <tr class="text-center align-middle">
                        <td class="text-muted font-mono small">${index + 1}</td>
                        <td class="text-start">
                            <div class="fw-bold text-dark">${item.text}</div>
                            <small class="text-muted font-mono">${item.nomor_sku}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border font-mono px-2">${item.nomor_batch}</span></td>
                        <td><span class="badge bg-primary px-3 rounded-pill">${item.qty}</span></td>
                        <td class="text-end font-mono">Rp ${numberFormat.format(item.harga)}</td>
                        <td class="text-end fw-bold text-primary font-mono">Rp ${numberFormat.format(item.subTotal)}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-link text-danger btn-delete"
                                    data-sku="${item.nomor_sku}" data-batch="${item.nomor_batch}">
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

    // 4. Hapus Item
    $(document).on("click", ".btn-delete", function() {
        let sku = $(this).data('sku');
        let batch = $(this).data('batch');
        selectedProduk = selectedProduk.filter(item =>
            !(item.nomor_sku === sku && item.nomor_batch === batch)
        );
        renderTable();
    });

    // 5. Simpan ke Database via AJAX
    $("#btn-save-transaksi").on("click", function() {
        if (selectedProduk.length === 0) {
            swal({ icon: 'error', title: 'Gagal', text: 'Wajib mengisi minimal 1 barang!' });
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Proses...');

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
                if (response.success) {
                    swal({ icon: 'success', title: 'Berhasil', text: 'Transaksi berhasil disimpan!' })
                    .then(() => window.location.href = response.redirect_url);
                } else {
                    swal({ icon: 'error', title: 'Gagal', text: response.message });
                    btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> SIMPAN TRANSAKSI');
                }
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Kesalahan server.";
                swal({ icon: 'error', title: 'Error', text: errorMsg });
                btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> SIMPAN TRANSAKSI');
            }
        });
    });

    renderTable();
});
</script>
@endpush
