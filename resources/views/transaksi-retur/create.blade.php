@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')

<style>
    .page-inner { background: #f1f3f7; perspective: 1000px; }

    /* Card Utama */
    .card-3d {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.6);
        overflow: hidden;
    }

    .header-3d {
        background: #1a2035;
        color: #fff;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 4px solid #f99f2a;
    }

    /* Informasi Transaksi Asal (Dokumen Style) */
    .info-transaksi-box {
        background: #f8fafc;
        border-radius: 15px;
        padding: 20px;
        border-left: 5px solid #4e73df;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .info-label { font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 0; }
    .info-value { font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }

    /* Form Section */
    .form-section-3d {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }

    .label-3d { font-weight: 800; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.7rem; margin-bottom: 6px; }

    .input-3d, .select2-container--bootstrap-5 .select2-selection {
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #f8fafc !important;
        transition: all 0.3s;
    }

    /* Table Styles */
    .table-container-3d { border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
    .table-3d thead { background: #f1f5f9; }
    .table-3d th { font-size: 10px; font-weight: 800; text-transform: uppercase; color: #64748b; padding: 12px; border: none !important; }
    .table-3d td { vertical-align: middle; padding: 12px; font-size: 0.9rem; }

    .text-end-custom { text-align: right !important; padding-right: 20px !important; }

    /* Buttons */
    .btn-3d-add {
        background: #1a2035;
        color: white;
        border-radius: 10px;
        font-weight: 800;
        padding: 10px;
        box-shadow: 0 4px 0 #000;
        transition: 0.1s;
    }
    .btn-3d-add:active { transform: translateY(4px); box-shadow: 0 0 0 #000; }

    .btn-3d-save {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
    }

    .grand-total-box {
        background: #1a2035;
        color: #f99f2a;
        padding: 15px 25px;
        border-radius: 12px;
        text-align: right;
    }
</style>

<div class="card card-3d">
    <div class="header-3d">
        <h4 class="mb-0 fw-bold"><i class="fas fa-undo me-2"></i> Form Retur Barang</h4>
        <button class="btn-3d-save" id="btn-submit-retur">
            <i class="fas fa-save me-2"></i> SIMPAN RETUR
        </button>
    </div>

    <div class="card-body p-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="label-3d">Cari Nomor Transaksi Asal</label>
                <select id="select-transaksi" class="form-control input-3d"></select>
            </div>
        </div>

        <div class="info-transaksi-box">
            <div class="row">
                <div class="col-md-3 col-6">
                    <p class="info-label">Nomor Transaksi</p>
                    <div class="info-value" id="nomor_transaksi">-</div>
                </div>
                <div class="col-md-3 col-6">
                    <p class="info-label">Tanggal Keluar</p>
                    <div class="info-value" id="tanggal">-</div>
                </div>
                <div class="col-md-3 col-6">
                    <p class="info-label">Customer / Penerima</p>
                    <div class="info-value" id="pengirim">-</div>
                </div>
                <div class="col-md-3 col-6">
                    <p class="info-label">Total Nilai</p>
                    <div class="info-value text-primary" id="total_harga">Rp 0</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="form-section-3d">
                    <h6 class="fw-bold mb-3 text-dark">Input Item Retur</h6>

                    <div class="mb-3">
                        <label class="label-3d">Pilih Barang dari Transaksi</label>
                        <select id="select-transaksi-items" class="form-control input-3d"></select>
                    </div>

                    <div class="mb-3">
                        <label class="label-3d">Alasan Retur (Note)</label>
                        <textarea id="note" class="form-control input-3d" rows="3" placeholder="Misal: Barang Cacat/Rusak"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="label-3d">Jumlah Retur (Qty)</label>
                        <input type="number" id="qty" class="form-control input-3d" placeholder="0">
                    </div>

                    <button class="btn-3d-add w-100" id="btn-add">
                        <i class="fas fa-plus me-2"></i> TAMBAHKAN
                    </button>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="table-container-3d">
                    <table class="table table-hover table-3d mb-0" id="table-retur">
                        <thead>
                            <tr class="text-center">
                                <th width="40">No</th>
                                <th class="text-start">Barang</th>
                                <th>Alasan</th>
                                <th>Qty</th>
                                <th class="text-end-custom">Subtotal</th>
                                <th width="50">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <div class="grand-total-box">
                        <span class="info-label text-white opacity-75">Estimasi Nilai Retur</span>
                        <h3 class="mb-0 fw-bold" id="grand-total">Rp 0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
$(document).ready(function() {
    let selectedItem = {};
    let returItems = [];
    const numberFormat = new Intl.NumberFormat('id-ID');

    $("#select-transaksi").select2({
        placeholder: 'Pilih Nomor Transaksi',
        allowClear: true,
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('get-data.transaksi-keluar') }}",
            dataType: 'json',
            delay: 250,
            data: params => ({ search: params.term }),
            processResults: data => ({
                results: data.map(item => ({ id: item.id, text: item.text }))
            }),
            cache: true
        }
    });

    function getItemsTransaksi(nomor_transaksi) {
        $.ajax({
            type: "GET",
            url: `/get-data/transaksi-keluar/${nomor_transaksi}`,
            success: function(response) {
                // Update Info Header
                $("#nomor_transaksi").text(response.nomor_transaksi);
                $("#tanggal").text(response.tanggal);
                $("#pengirim").text(response.penerima || response.pengirim);
                $("#total_harga").text(`Rp. ${numberFormat.format(response.total_harga)}`);

                // Map data untuk Select2 Items
                let items = response.items.map(item => ({
                    id: item.id,
                    text: `${item.produk} - ${item.varian.nama_varian}`,
                    qty_asal: item.qty,
                    harga: item.harga,
                    nomor_batch: item.nomor_batch,
                    nomor_sku: item.nomor_sku
                }));

                $("#select-transaksi-items").empty().append('<option value=""></option>').select2({
                    placeholder: "Pilih Barang di Transaksi Ini",
                    theme: 'bootstrap-5',
                    data: items
                });
            }
        });
    }

    $("#select-transaksi").on("select2:select", function(e) {
        getItemsTransaksi(e.params.data.text);
    });

    $("#select-transaksi-items").on("select2:select", function(e) {
        selectedItem = e.params.data;
    });

    $("#btn-add").on("click", function(e) {
        e.preventDefault();
        let note = $("#note").val();
        let qty = parseInt($("#qty").val());

        if(!selectedItem.id || !note || !qty) {
            swal({ icon: 'warning', title: 'Gagal', text: 'Mohon isi barang, alasan, dan qty!' });
            return;
        }
        if(qty > selectedItem.qty_asal) {
            swal({ icon: 'error', title: 'Qty Berlebih', text: `Maksimal qty yang bisa diretur: ${selectedItem.qty_asal}` });
            return;
        }

        let exist = returItems.find(item => item.nomor_sku === selectedItem.nomor_sku);
        if(exist) {
            exist.qty = qty; // Update qty jika barang yang sama dipilih lagi
            exist.subTotal = qty * exist.harga;
            exist.note = note;
        } else {
            returItems.push({
                varian_id: selectedItem.id,
                text: selectedItem.text,
                note: note,
                qty: qty,
                harga: selectedItem.harga,
                subTotal: selectedItem.harga * qty,
                nomor_batch: selectedItem.nomor_batch,
                nomor_sku: selectedItem.nomor_sku
            });
        }

        $("#qty, #note").val("");
        $("#select-transaksi-items").val("").trigger("change");
        renderTable();
    });

    function renderTable() {
        let tableBody = $("#table-retur tbody");
        tableBody.empty();

        if(returItems.length === 0) {
            tableBody.append(`<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada barang siap retur</td></tr>`);
        } else {
            returItems.forEach((item, index) => {
                tableBody.append(`
                    <tr class="text-center">
                        <td>${index + 1}</td>
                        <td class="text-start"><strong>${item.text}</strong><br><small class="text-muted">Batch: ${item.nomor_batch}</small></td>
                        <td><span class="badge bg-light text-dark border">${item.note}</span></td>
                        <td><span class="badge bg-primary px-3 rounded-pill">${item.qty}</span></td>
                        <td class="text-end-custom fw-bold">Rp ${numberFormat.format(item.subTotal)}</td>
                        <td>
                            <button class="btn btn-link text-danger btn-delete" data-sku="${item.nomor_sku}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        let grandTotal = returItems.reduce((total, item) => total + item.subTotal, 0);
        $("#grand-total").text(`Rp ${numberFormat.format(grandTotal)}`);
    }

    $(document).on("click", ".btn-delete", function() {
        let sku = $(this).data("sku");
        returItems = returItems.filter(item => item.nomor_sku !== sku);
        renderTable();
    });

    $("#btn-submit-retur").on("click", function() {
        let nomor_transaksi = $("#nomor_transaksi").text();
        if(returItems.length === 0) {
            swal({ icon: 'warning', text: 'Daftar retur masih kosong!' });
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{ route('transaksi-retur.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                nomor_transaksi: nomor_transaksi,
                items: returItems
            },
            success: function (res) {
                if(res.success) window.location.href = res.redirect_url;
            }
        });
    });

    renderTable();
});
</script>
@endpush
