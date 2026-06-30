<?php $__env->startSection('page_title', 'Export Laporan'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__currentLoopData = [
                        ['val' => 'produk', 'id' => 'cek-produk', 'icon' => 'fa-box', 'label' => 'Data Barang', 'desc' => 'Semua produk, kategori, dan status stok', 'tanggal' => 0],
                        ['val' => 'supplier', 'id' => 'cek-supplier', 'icon' => 'fa-truck', 'label' => 'Data Supplier', 'desc' => 'Seluruh data supplier terdaftar', 'tanggal' => 0],
                        ['val' => 'rak', 'id' => 'cek-rak', 'icon' => 'fa-warehouse', 'label' => 'Kapasitas Rak', 'desc' => 'Kondisi kapasitas rak saat ini', 'tanggal' => 0],
                        ['val' => 'transaksi-masuk', 'id' => 'cek-masuk', 'icon' => 'fa-arrow-down', 'label' => 'Transaksi Masuk', 'desc' => 'Detail per item barang masuk', 'tanggal' => 1],
                        ['val' => 'transaksi-keluar', 'id' => 'cek-keluar', 'icon' => 'fa-arrow-up', 'label' => 'Transaksi Keluar', 'desc' => 'Detail per item barang keluar', 'tanggal' => 1],
                        ['val' => 'transaksi-retur', 'id' => 'cek-retur', 'icon' => 'fa-undo', 'label' => 'Transaksi Retur', 'desc' => 'Seluruh retur ke supplier maupun gudang', 'tanggal' => 1],
                        ['val' => 'kartu-stok', 'id' => 'cek-kartustok', 'icon' => 'fa-clipboard-list', 'label' => 'Kartu Stok', 'desc' => 'Seluruh log pergerakan stok', 'tanggal' => 1],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-checkbox mt-1" type="checkbox" value="<?php echo e($item['val']); ?>" id="<?php echo e($item['id']); ?>" data-butuh-tanggal="<?php echo e($item['tanggal']); ?>">
                            <label class="form-check-label w-100" for="<?php echo e($item['id']); ?>">
                                <i class="fas <?php echo e($item['icon']); ?> me-1" style="color: var(--sigma-navy-500)"></i> <strong><?php echo e($item['label']); ?></strong>
                                <br><small class="text-muted"><?php echo e($item['desc']); ?></small>
                            </label>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    'produk': "<?php echo e(route('export.produk')); ?>",
    'supplier': "<?php echo e(route('export.supplier')); ?>",
    'rak': "<?php echo e(route('export.rak')); ?>",
    'transaksi-masuk': "<?php echo e(route('export.transaksi-masuk')); ?>",
    'transaksi-keluar': "<?php echo e(route('export.transaksi-keluar')); ?>",
    'transaksi-retur': "<?php echo e(route('export.transaksi-retur')); ?>",
    'kartu-stok': "<?php echo e(route('export.kartu-stok')); ?>",
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
        const butuhTanggal = cb.dataset.butuhTanggal === '1';
        let url = RUTE_EXPORT[cb.value];

        if (butuhTanggal && dari && sampai) {
            url += `?dari=${dari}&sampai=${sampai}`;
        }

        // Menggunakan teknik penundaan dan elemen link untuk download beruntun
        setTimeout(() => {
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('target', '_blank');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }, index * 800);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/export-laporan/index.blade.php ENDPATH**/ ?>