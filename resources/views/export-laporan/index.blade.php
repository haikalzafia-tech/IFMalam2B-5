@extends('layouts.kai')
@section('page_title', 'Export Laporan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fas fa-file-excel me-2" style="color: var(--sigma-success)"></i>Export Laporan ke Excel</h4>
                <small class="text-muted">Pilih laporan yang ingin diexport. Setiap laporan akan diunduh sebagai file Excel terpisah.</small>
            </div>
            <div class="card-body">

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Rentang tanggal di bawah berlaku untuk laporan <strong>Transaksi Masuk</strong>,
                    <strong>Transaksi Keluar</strong>, <strong>Transaksi Retur</strong>, dan <strong>Kartu Stok</strong>.
                    Kosongkan jika ingin mengexport seluruh data tanpa batasan periode.
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" id="filter-dari" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" id="filter-sampai" class="form-control">
                    </div>
                </div>

                <label class="form-label">Pilih Laporan</label>
                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="produk" id="cek-produk" data-butuh-tanggal="0">
                            <label class="form-check-label w-100" for="cek-produk">
                                <i class="fas fa-box me-1" style="color: var(--sigma-navy-500)"></i> <strong>Data Barang</strong>
                                <br><small class="text-muted">Semua produk, kategori, dan status stok</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="supplier" id="cek-supplier" data-butuh-tanggal="0">
                            <label class="form-check-label w-100" for="cek-supplier">
                                <i class="fas fa-truck me-1" style="color: var(--sigma-navy-500)"></i> <strong>Data Supplier</strong>
                                <br><small class="text-muted">Seluruh data supplier terdaftar</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="rak" id="cek-rak" data-butuh-tanggal="0">
                            <label class="form-check-label w-100" for="cek-rak">
                                <i class="fas fa-warehouse me-1" style="color: var(--sigma-navy-500)"></i> <strong>Kapasitas Rak</strong>
                                <br><small class="text-muted">Kondisi kapasitas rak saat ini</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="transaksi-masuk" id="cek-masuk" data-butuh-tanggal="1">
                            <label class="form-check-label w-100" for="cek-masuk">
                                <i class="fas fa-arrow-down me-1" style="color: var(--sigma-success)"></i> <strong>Transaksi Masuk</strong>
                                <br><small class="text-muted">Detail per item barang masuk</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="transaksi-keluar" id="cek-keluar" data-butuh-tanggal="1">
                            <label class="form-check-label w-100" for="cek-keluar">
                                <i class="fas fa-arrow-up me-1" style="color: var(--sigma-info)"></i> <strong>Transaksi Keluar</strong>
                                <br><small class="text-muted">Detail per item barang keluar</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="transaksi-retur" id="cek-retur" data-butuh-tanggal="1">
                            <label class="form-check-label w-100" for="cek-retur">
                                <i class="fas fa-undo me-1" style="color: var(--sigma-danger)"></i> <strong>Transaksi Retur</strong>
                                <br><small class="text-muted">Seluruh retur ke supplier maupun gudang</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="kartu-stok" id="cek-kartustok" data-butuh-tanggal="1">
                            <label class="form-check-label w-100" for="cek-kartustok">
                                <i class="fas fa-clipboard-list me-1" style="color: var(--sigma-warning)"></i> <strong>Kartu Stok</strong>
                                <br><small class="text-muted">Seluruh log pergerakan stok</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <button type="button" id="btn-pilih-semua" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-check-double me-1"></i> Pilih Semua
                    </button>
                    <button type="button" id="btn-export-terpilih" class="btn btn-success">
                        <i class="fas fa-download me-1"></i> Export Laporan Terpilih
                    </button>
                    <span id="info-jumlah-terpilih" class="text-muted small"></span>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
const RUTE_EXPORT = {
    'produk': "{{ route('export.produk') }}",
    'supplier': "{{ route('export.supplier') }}",
    'rak': "{{ route('export.rak') }}",
    'transaksi-masuk': "{{ route('export.transaksi-masuk') }}",
    'transaksi-keluar': "{{ route('export.transaksi-keluar') }}",
    'transaksi-retur': "{{ route('export.transaksi-retur') }}",
    'kartu-stok': "{{ route('export.kartu-stok') }}",
};

const semuaCheckbox = document.querySelectorAll('.laporan-checkbox');
const btnPilihSemua = document.getElementById('btn-pilih-semua');
const btnExport = document.getElementById('btn-export-terpilih');
const infoJumlah = document.getElementById('info-jumlah-terpilih');

function updateInfoJumlah() {
    const jumlah = document.querySelectorAll('.laporan-checkbox:checked').length;
    infoJumlah.textContent = jumlah > 0 ? `${jumlah} laporan dipilih` : '';
}

semuaCheckbox.forEach(cb => cb.addEventListener('change', updateInfoJumlah));

btnPilihSemua.addEventListener('click', function () {
    const semuaTercentang = document.querySelectorAll('.laporan-checkbox:checked').length === semuaCheckbox.length;
    semuaCheckbox.forEach(cb => cb.checked = !semuaTercentang);
    this.innerHTML = semuaTercentang
        ? '<i class="fas fa-check-double me-1"></i> Pilih Semua'
        : '<i class="fas fa-times me-1"></i> Batal Semua';
    updateInfoJumlah();
});

btnExport.addEventListener('click', function () {
    const terpilih = Array.from(document.querySelectorAll('.laporan-checkbox:checked'));

    if (terpilih.length === 0) {
        SigmaNotif.gagal('Pilih minimal 1 laporan untuk diexport.');
        return;
    }

    const dari = document.getElementById('filter-dari').value;
    const sampai = document.getElementById('filter-sampai').value;

    if ((dari && !sampai) || (!dari && sampai)) {
        SigmaNotif.gagal('Isi kedua tanggal (Dari dan Sampai), atau kosongkan keduanya.');
        return;
    }

    SigmaNotif.sukses(`Mengunduh ${terpilih.length} laporan...`);

    terpilih.forEach((cb, index) => {
        setTimeout(() => {
            const butuhTanggal = cb.dataset.butuhTanggal === '1';
            let url = RUTE_EXPORT[cb.value];

            if (butuhTanggal && dari && sampai) {
                url += `?dari=${dari}&sampai=${sampai}`;
            }

            window.location.href = url;
        }, index * 600);
    });
});
</script>
@endsection
