@extends('layouts.kai')
@section('page_title', 'Transaksi Masuk Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Transaksi Barang Masuk</h4>
                <a href="{{ route('transaksi-masuk.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('transaksi-masuk.store') }}" method="POST" id="form-masuk">
                    @csrf

                    {{-- Info Transaksi --}}
                    <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Transaksi</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Gudang Tujuan <span class="text-danger">*</span></label>
                            <select name="gudang_id" id="gudang_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Supplier</label>
                            <select name="supplier_id" class="form-select select2">
                                <option value="">-- Tanpa Supplier --</option>
                                @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->kode_supplier }} - {{ $s->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Nomor PO</label>
                            <input type="text" name="nomor_po" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nomor Surat Jalan</label>
                            <input type="text" name="nomor_surat_jalan" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan tambahan (opsional)">
                        </div>
                    </div>

                    {{-- Items Barang --}}
                    <h6 class="text-muted mb-3"><i class="fas fa-boxes me-1"></i> Daftar Barang Masuk</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-items">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width:220px">Barang (SKU)</th>
                                    <th style="min-width:160px">Rak Tujuan</th>
                                    <th style="width:90px">Qty</th>
                                    <th style="min-width:140px">No. Batch</th>
                                    <th style="min-width:140px">Tgl Produksi</th>
                                    <th style="min-width:140px">Tgl Kadaluarsa</th>
                                    <th style="width:110px">Kondisi</th>
                                    <th style="width:40px"></th>
                                </tr>
                            </thead>
                            <tbody id="items-body">
                                {{-- Row template akan di-clone via JS --}}
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btn-add-row" class="btn btn-sm btn-outline-primary mb-4">
                        <i class="fas fa-plus me-1"></i> Tambah Barang
                    </button>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Transaksi</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('transaksi-masuk.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Data varian produk untuk dropdown, di-render sebagai JSON --}}
<script>
const VARIAN_LIST = @json($varianProduks->map(fn($v) => [
    'id' => $v->id,
    'label' => $v->nomor_sku . ' - ' . $v->produk->nama_produk . ' (' . $v->nama_varian . ')',
    'rak_id' => $v->rak_id,
]));

let rowIndex = 0;

function buatRowHTML(index) {
    let options = '<option value="">-- Pilih Barang --</option>';
    VARIAN_LIST.forEach(v => {
        options += `<option value="${v.id}">${v.label}</option>`;
    });

    return `
    <tr data-row="${index}">
        <td>
            <select name="items[${index}][varian_produk_id]" class="form-select form-select-sm" required>
                ${options}
            </select>
        </td>
        <td>
            <select name="items[${index}][rak_id]" class="form-select form-select-sm rak-select" required>
                <option value="">-- Pilih Gudang Dulu --</option>
            </select>
        </td>
        <td><input type="number" name="items[${index}][qty]" class="form-control form-control-sm" min="1" required></td>
        <td><input type="text" name="items[${index}][nomor_batch]" class="form-control form-control-sm" placeholder="Opsional"></td>
        <td><input type="date" name="items[${index}][tanggal_produksi]" class="form-control form-control-sm"></td>
        <td><input type="date" name="items[${index}][tanggal_kadaluarsa]" class="form-control form-control-sm"></td>
        <td>
            <select name="items[${index}][kondisi]" class="form-select form-select-sm">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="cacat">Cacat</option>
            </select>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-xs btn-danger btn-remove-row"><i class="fas fa-times"></i></button>
        </td>
    </tr>`;
}

function tambahRow() {
    const tbody = document.getElementById('items-body');
    tbody.insertAdjacentHTML('beforeend', buatRowHTML(rowIndex));
    rowIndex++;
    updateRakOptions();
}

function updateRakOptions() {
    loadRakByGudang();
}

// Karena rak terkait ke zona (bukan langsung gudang), kita ambil semua rak by gudang via endpoint:
async function loadRakByGudang() {
    const gudangId = document.getElementById('gudang_id').value;
    const rakSelects = document.querySelectorAll('.rak-select');

    if (!gudangId) {
        rakSelects.forEach(sel => sel.innerHTML = '<option value="">-- Pilih Gudang Dulu --</option>');
        return;
    }

    try {
        const res = await fetch(`{{ route('master-data.rak.by-gudang') }}?gudang_id=${gudangId}`);
        const raks = await res.json();
        let opts = '<option value="">-- Pilih Rak --</option>';
        raks.forEach(r => {
            opts += `<option value="${r.id}">${r.kode_rak} - ${r.nama_rak} (sisa: ${r.sisa_kapasitas})</option>`;
        });
        rakSelects.forEach(sel => sel.innerHTML = opts);
    } catch (e) {
        console.error('Gagal load rak', e);
    }
}

document.getElementById('gudang_id').addEventListener('change', loadRakByGudang);
document.getElementById('btn-add-row').addEventListener('click', tambahRow);

document.getElementById('items-body').addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-row')) {
        const row = e.target.closest('tr');
        if (document.querySelectorAll('#items-body tr').length > 1) {
            row.remove();
        } else {
            alert('Minimal harus ada 1 barang.');
        }
    }
});

// Inisialisasi 1 row pertama
tambahRow();
</script>
@endsection
