<?php $__env->startSection('page_title', 'Detail Transaksi Keluar'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Transaksi</h4>
                <a href="<?php echo e(route('transaksi-keluar.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-3">
                    <tr><td class="text-muted">No. Transaksi</td><td><span class="badge bg-primary"><?php echo e($transaksi->nomor_transaksi); ?></span></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td><?php echo e($transaksi->tanggal_transaksi->format('d/m/Y')); ?></td></tr>
                    <tr><td class="text-muted">Gudang</td><td><?php echo e($transaksi->gudang->nama_gudang); ?></td></tr>
                    <tr><td class="text-muted">Penerima</td><td><?php echo e($transaksi->penerima); ?></td></tr>
                    <tr><td class="text-muted">Tujuan</td><td><?php echo e($transaksi->tujuan ?? '-'); ?></td></tr>
                    <tr><td class="text-muted">No. Surat Jalan</td><td><?php echo e($transaksi->nomor_surat_jalan ?? '-'); ?></td></tr>
                    <tr><td class="text-muted">Petugas</td><td><?php echo e($transaksi->petugas); ?></td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td>
                            <?php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; ?>
                            <span class="badge bg-<?php echo e($statusColor[$transaksi->status]); ?>"><?php echo e(ucfirst($transaksi->status)); ?></span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Total Barang</td><td class="fw-bold"><?php echo e($transaksi->jumlah_barang); ?></td></tr>
                </table>
                <?php if($transaksi->keterangan): ?>
                <hr style="border-color: var(--sigma-border)">
                <small class="text-muted d-block">Keterangan:</small>
                <p class="mb-0"><?php echo e($transaksi->keterangan); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Daftar Barang Keluar</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>Rak Asal</th>
                                <th class="text-center">Qty</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transaksi->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($item->varianProduk->nomor_sku); ?></span></td>
                                <td class="fw-semibold"><?php echo e($item->varianProduk->produk->nama_produk); ?> - <?php echo e($item->varianProduk->nama_varian); ?></td>
                                <td><?php echo e($item->rak->kode_rak ?? '-'); ?> (<?php echo e($item->rak->zona->nama_zona ?? '-'); ?>)</td>
                                <td class="text-center fw-bold"><?php echo e($item->qty); ?></td>
                                <td><?php echo e($item->catatan ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/transaksi-keluar/show.blade.php ENDPATH**/ ?>