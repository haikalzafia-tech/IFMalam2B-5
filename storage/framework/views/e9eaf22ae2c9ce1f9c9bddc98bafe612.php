<?php $__env->startSection('page_title', 'Ekspor Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fas fa-file-excel me-2" style="color: var(--sigma-success)"></i>Ekspor Laporan ke Excel</h4>
                <small class="text-muted">Pilih satu laporan yang ingin diekpor.</small>
            </div>
            <div class="card-body">

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Rentang tanggal berlaku untuk laporan Transaksi dan Kartu Stok.
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
                        ['val' => 'produk', 'id' => 'cek-produk', 'icon' => 'fa-box', 'label' => 'Data Barang', 'tanggal' => 0],
                        ['val' => 'supplier', 'id' => 'cek-supplier', 'icon' => 'fa-truck', 'label' => 'Data Supplier', 'tanggal' => 0],
                        ['val' => 'rak', 'id' => 'cek-rak', 'icon' => 'fa-warehouse', 'label' => 'Kapasitas Rak', 'tanggal' => 0],
                        ['val' => 'transaksi-masuk', 'id' => 'cek-masuk', 'icon' => 'fa-arrow-down', 'label' => 'Transaksi Masuk', 'tanggal' => 1],
                        ['val' => 'transaksi-keluar', 'id' => 'cek-keluar', 'icon' => 'fa-arrow-up', 'label' => 'Transaksi Keluar', 'tanggal' => 1],
                        ['val' => 'transaksi-retur', 'id' => 'cek-retur', 'icon' => 'fa-undo', 'label' => 'Transaksi Retur', 'tanggal' => 1],
                        ['val' => 'kartu-stok', 'id' => 'cek-kartustok', 'icon' => 'fa-clipboard-list', 'label' => 'Kartu Stok', 'tanggal' => 1],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="form-check border rounded-3 p-3 d-flex align-items-start gap-2 h-100" style="border-color: var(--sigma-border) !important;">
                            <input class="form-check-input flex-shrink-0 laporan-radio mt-1" type="radio" name="laporan_pilihan" value="<?php echo e($item['val']); ?>" id="<?php echo e($item['id']); ?>" data-butuh-tanggal="<?php echo e($item['tanggal']); ?>">
                            <label class="form-check-label w-100" for="<?php echo e($item['id']); ?>">
                                <i class="fas <?php echo e($item['icon']); ?> me-1" style="color: var(--sigma-navy-500)"></i> <strong><?php echo e($item['label']); ?></strong>
                            </label>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="d-flex align-items-center">
                    <button type="button" id="btn-export-terpilih" class="btn btn-success">
                        <i class="fas fa-download me-1"></i> Ekpor Laporan
                    </button>
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

document.getElementById('btn-export-terpilih').addEventListener('click', function () {
    const terpilih = document.querySelector('.laporan-radio:checked');

    if (!terpilih) {
        SigmaNotif.gagal('Pilih salah satu laporan untuk diekpor.');
        return;
    }

    const dari = document.getElementById('filter-dari').value;
    const sampai = document.getElementById('filter-sampai').value;

    if ((dari && !sampai) || (!dari && sampai)) {
        SigmaNotif.gagal('Isi kedua tanggal, atau kosongkan keduanya.');
        return;
    }

    const butuhTanggal = terpilih.dataset.butuhTanggal === '1';
    let url = RUTE_EXPORT[terpilih.value];

    if (butuhTanggal && dari && sampai) {
        url += `?dari=${dari}&sampai=${sampai}`;
    }

    // Karena hanya 1, kita bisa langsung redirect
    window.location.href = url;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/export-laporan/index.blade.php ENDPATH**/ ?>