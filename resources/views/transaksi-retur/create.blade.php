@extends('layouts.kai')
@section('page_title', 'Buat Retur Baru')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Form Transaksi Retur</h4>
        <a href="{{ route('transaksi-retur.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('transaksi-retur.store') }}" method="POST" id="form-retur">
            @csrf

            <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-info-circle me-1"></i> Informasi Retur</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Transaksi Asal <span class="text-danger">*</span></label>
                    <select name="transaksi_id" id="transaksi_id" class="form-select select2" required>
                        <option value="">-- Pilih Transaksi --</option>
                        @foreach($transaksis as $t)
                        <option value="{{ $t->id }}" {{ ($transaksiTerpilih && $transaksiTerpilih->id == $t->id) ? 'selected' : '' }}>
                            {{ $t->nomor_transaksi }} - {{ $t->tanggal_transaksi->format('d/m/Y') }}
                            ({{ $t->supplier->nama_supplier ?? 'Tanpa Supplier' }})
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih transaksi yang barangnya ingin diretur</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Retur <span class="text-danger">*</span></label>
                    <select name="jenis_retur" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="retur_masuk">Masuk ke Gudang</option>
                        <option value="retur_keluar">Keluar ke Supplier</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gudang <span class="text-danger">*</span></label>
                    <select name="gudang_id" class="form-select" required>
                        <option value="">-- Pilih Gudang --</option>
                        @foreach($gudangs as $g)
                        <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Retur <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_retur" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alasan Retur <span class="text-danger">*</span></label>
                    <textarea name="alasan_retur" class="form-control" rows="2" placeholder="Jelaskan alasan retur (barang rusak, salah kirim, cacat produksi, dll)" required></textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"></textarea>
                </div>
            </div>

            <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-boxes me-1"></i> Daftar Barang Retur</h6>
            <div id="alert-pilih-transaksi" class="alert alert-info">
                Silakan pilih transaksi asal terlebih dahulu untuk menampilkan daftar barang.
            </div>

            <div class="table-responsive d-none mb-2" id="wrapper-items">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr class="text-center bg-light">
                            <th style="width: 60px;">Pilih</th>
                            <th style="min-width: 220px;" class="text-start">Barang</th>
                            <th style="width: 100px;">Qty Asal</th>
                            <th style="width: 110px;">Qty Retur</th>
                            <th style="min-width: 140px;">Kondisi Barang</th>
                            <th style="min-width: 160px;">Keterangan Kondisi</th>
                        </tr>
                    </thead>
                    <tbody id="items-body"></tbody>
                </table>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Retur</button>
                <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('transaksi-retur.index') }}')">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
let itemIndex = 0;

async function loadItemsByTransaksi(transaksiId) {
    const wrapper = document.getElementById('wrapper-items');
    const alertInfo = document.getElementById('alert-pilih-transaksi');
    const tbody = document.getElementById('items-body');

    if (!transaksiId) {
        wrapper.classList.add('d-none');
        alertInfo.classList.remove('d-none');
        tbody.innerHTML = '';
        return;
    }

    try {
        const res = await fetch(`/get-items-transaksi/${transaksiId}`);
        const items = await res.json();

        tbody.innerHTML = '';
        items.forEach((item, idx) => {
            const namaBarang = item.varian_produk
                ? `${item.varian_produk.produk?.nama_produk ?? ''} - ${item.varian_produk.nama_varian ?? ''}`
                : 'Barang tidak ditemukan';

            tbody.insertAdjacentHTML('beforeend', `
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input chk-pilih" style="width:20px; height:20px; cursor:pointer;">
                </td>
                <td>
                    ${namaBarang}
                    <input type="hidden" class="chk-varian" value="${item.varian_produk_id}">
                    <input type="hidden" class="chk-transaksi-item" value="${item.id}">
                </td>
                <td class="text-center fw-bold">${item.qty}</td>
                <td>
                    <input type="number" class="form-control form-control-sm input-qty-retur text-center" min="1" max="${item.qty}" placeholder="0" disabled required>
                </td>
                <td>
                    <select class="form-select form-select-sm input-kondisi" disabled>
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="cacat">Cacat</option>
                        <option value="kadaluarsa">Kadaluarsa</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-ket" placeholder="Opsional" disabled>
                </td>
            </tr>`);
        });

        wrapper.classList.remove('d-none');
        alertInfo.classList.add('d-none');
    } catch (e) {
        console.error('Gagal load item transaksi', e);
    }
}

document.getElementById('transaksi_id').addEventListener('change', function() {
    loadItemsByTransaksi(this.value);
});

document.getElementById('items-body').addEventListener('change', function(e) {
    if (e.target.classList.contains('chk-pilih')) {
        const row = e.target.closest('tr');
        const inputs = row.querySelectorAll('.input-qty-retur, .input-kondisi, .input-ket');
        inputs.forEach(inp => inp.disabled = !e.target.checked);
    }
});

document.getElementById('form-retur').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('#items-body tr');
    let index = 0;
    let adaTerpilih = false;

    // Hapus input hidden lama jika ada (mencegah duplikasi data saat klik submit berulang)
    const oldHiddenInputs = this.querySelectorAll('input[type="hidden"][name^="items["]');
    oldHiddenInputs.forEach(el => el.remove());

    rows.forEach(row => {
        const checked = row.querySelector('.chk-pilih').checked;
        if (checked) {
            adaTerpilih = true;
            const varianId = row.querySelector('.chk-varian').value;
            const transaksiItemId = row.querySelector('.chk-transaksi-item').value;
            const qty = row.querySelector('.input-qty-retur').value;
            const kondisi = row.querySelector('.input-kondisi').value;
            const ket = row.querySelector('.input-ket').value;

            const fields = {
                [`items[${index}][varian_produk_id]`]: varianId,
                [`items[${index}][transaksi_item_id]`]: transaksiItemId,
                [`items[${index}][qty_retur]`]: qty,
                [`items[${index}][kondisi_barang]`]: kondisi,
                [`items[${index}][keterangan_kondisi]`]: ket,
            };

            for (const [name, value] of Object.entries(fields)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                this.appendChild(input);
            }
            index++;
        }
    });

    if (!adaTerpilih) {
        e.preventDefault();
        SigmaNotif.gagal('Pilih minimal 1 barang yang akan diretur (centang checkbox).');
    }
});

@if($transaksiTerpilih)
loadItemsByTransaksi({{ $transaksiTerpilih->id }});
@endif
</script>
@endsection
