<?php $__env->startSection('page_title', 'Kelebihan Kapasitas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title" style="color: var(--sigma-warning)">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Daftar Kelebihan Kapasitas Belum Diselesaikan
        </h4>
        <small class="text-muted">Barang yang sudah tercatat masuk stok namun belum punya lokasi rak yang pas.</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Barang</th>
                        <th>Rak Penuh</th>
                        <th class="text-center">Qty Lebih</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $daftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($k->created_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <a href="<?php echo e(route('transaksi-masuk.show', $k->transaksiItem->transaksi)); ?>">
                                <?php echo e($k->transaksiItem->transaksi->nomor_transaksi); ?>

                            </a>
                        </td>
                        <td class="fw-semibold"><?php echo e($k->varianProduk->produk->nama_produk); ?> - <?php echo e($k->varianProduk->nama_varian); ?></td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($k->rak->kode_rak); ?></span>
                            <small class="text-muted"><?php echo e($k->rak->zona->gudang->nama_gudang); ?></small>
                        </td>
                        <td class="text-center"><span class="badge bg-danger"><?php echo e($k->qty_lebih); ?></span></td>
                        <td class="text-center">
                            
                            <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                                <a href="<?php echo e(route('transaksi-masuk.show', $k->transaksiItem->transaksi)); ?>" class="btn btn-xs btn-primary">
                                    <i class="fas fa-tools me-1"></i> Selesaikan
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">Hubungi Admin</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-check-circle fa-2x mb-2 d-block" style="color: var(--sigma-success)"></i>
                            Tidak ada kelebihan kapasitas yang menunggu. Semua barang sudah punya lokasi.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($daftar->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/kelebihan-kapasitas/index.blade.php ENDPATH**/ ?>