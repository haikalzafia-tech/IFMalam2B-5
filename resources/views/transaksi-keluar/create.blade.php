@extends('layouts.kai')
@section('page_title', 'Transaksi Keluar Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Transaksi Barang Keluar</h4>
                <a href="{{ route('transaksi-keluar.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('transaksi-keluar.store') }}" method="POST" id="form-keluar">
                    @csrf

                    <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Transaksi</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Gudang Asal <span class="text-danger">*</span></label>
                            <select name="gudang_id" id="gudang_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="penerima" class="form-control" placeholder="Nama penerima barang" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" placeholder="Tujuan pengiriman (opsional)">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
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

                    <h6 class="text-muted mb-3"><i class="fas fa-boxes me-1"></i> Daftar Barang Keluar</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-items">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width:240px">Barang (SKU)</th>
                                    <th style="min-width:160px">Rak Asal</th>
                                    <th style="width:100px">Stok Tersedia</th>
                                    <th style="width:90px">Qty Keluar</th>
                                    <th style="width:140px">Catatan</th>
                                    <th style="width:40px"></th>
                                </tr>
                            </thead>
                            <tbody id="items-body"></tbody>
                        </table>
                    </div>
                    <button type="button" id="btn-add-row" class="btn btn-sm btn-outline-primary mb-4">
                        <i class="fas fa-plus me-1"></i> Tambah Barang
                    </button>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Transaksi</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('transaksi-keluar.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@php
    $varianListData = [];
    foreach ($varianProduks as $v) {
        $varianListData[] = [
            'id' => $v->id,
            'label' => $v->nomor_sku . ' - ' . $v->produk->nama_produk . ' (' . $v->nama_varian . ')',
            'stok' => $v->stok_varian,
            'rak_id' => $v->rak_id,
            'rak_nama' => $v->rak ? $v->rak->kode_rak . ' - ' . $v->rak->nama_rak : '-',
        ];
    }
@endphp
<script>
const VARIAN_LIST = @json($varianListData);

let rowIndex = 0;

function buatRowHTML(index) {
    let options = '<option value="">-- Pilih Barang --</option>';
    VARIAN_LIST.forEach(v => {
        options += `<option value="${v.id}" data-stok="${v.stok}" data-rak="${v.rak_id ?? ''}" data-rak-nama="${v.rak_nama}">${v.label}</option>`;
    });

    return `
    <tr data-row="${index}">
        <td>
            <select name="items[${index}][varian_produk_id]" class="form-select form-select-sm varian-select" required>
                ${options}
            </select>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm rak-display" readonly placeholder="-">
            <input type="hidden" name="items[${index}][rak_id]" class="rak-hidden">
        </td>
        <td>
            <span class="badge bg-info stok-display">-</span>
        </td>
        <td><input type="number" name="items[${index}][qty]" class="form-control form-control-sm qty-input" min="1" required></td>
        <td><input type="text" name="items[${index}][catatan]" class="form-control form-control-sm" placeholder="Opsional"></td>
        <td class="text-center">
            <button type="button" class="btn btn-xs btn-danger btn-remove-row"><i class="fas fa-times"></i></button>
        </td>
    </tr>`;
}

function tambahRow() {
    const tbody = document.getElementById('items-body');
    tbody.insertAdjacentHTML('beforeend', buatRowHTML(rowIndex));
    rowIndex++;
}

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

// Saat pilih varian, otomatis isi rak & stok tersedia
document.getElementById('items-body').addEventListener('change', function(e) {
    if (e.target.classList.contains('varian-select')) {
        const selected = e.target.options[e.target.selectedIndex];
        const row = e.target.closest('tr');
        const stok = selected.dataset.stok || 0;
        const rakId = selected.dataset.rak || '';
        const rakNama = selected.dataset.rakNama || '-';

        row.querySelector('.stok-display').textContent = stok;
        row.querySelector('.rak-display').value = rakNama;
        row.querySelector('.rak-hidden').value = rakId;
        row.querySelector('.qty-input').max = stok;
    }
});

// Validasi qty tidak boleh lebih dari stok
document.getElementById('form-keluar').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('#items-body tr');
    for (const row of rows) {
        const qty = parseInt(row.querySelector('.qty-input').value || 0);
        const stok = parseInt(row.querySelector('.stok-display').textContent || 0);
        if (qty > stok) {
            e.preventDefault();
            alert('Qty keluar tidak boleh lebih dari stok tersedia!');
            return false;
        }
    }
});

tambahRow();
</script>
@endsection
