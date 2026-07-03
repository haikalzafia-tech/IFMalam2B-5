<?php $__env->startSection('page_title', 'Detail Transaksi Retur'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Retur</h4>
                <a href="<?php echo e(route('transaksi-retur.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-3">
                    <tr><td class="text-muted">No. Retur</td><td><span class="badge bg-secondary"><?php echo e($transaksiRetur->nomor_retur); ?></span></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td><?php echo e($transaksiRetur->tanggal_retur->format('d/m/Y')); ?></td></tr>
                    <tr><td class="text-muted">Transaksi Asal</td>
                        <td>
                            <a href="<?php echo e(route('transaksi-masuk.show', $transaksiRetur->transaksi)); ?>">
                                <?php echo e($transaksiRetur->transaksi->nomor_transaksi); ?>

                            </a>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Jenis</td>
                        <td>
                            <span class="badge bg-<?php echo e($transaksiRetur->jenis_retur == 'retur_masuk' ? 'success' : 'warning'); ?>">
                                <?php echo e($transaksiRetur->jenis_retur == 'retur_masuk' ? 'Masuk Gudang' : 'Keluar Supplier'); ?>

                            </span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Gudang</td><td><?php echo e($transaksiRetur->gudang->nama_gudang); ?></td></tr>
                    <tr><td class="text-muted">Supplier</td><td><?php echo e($transaksiRetur->supplier->nama_supplier ?? '-'); ?></td></tr>
                    <tr><td class="text-muted">Petugas</td><td><?php echo e($transaksiRetur->petugas); ?></td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td>
                            <?php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; ?>
                            <span class="badge bg-<?php echo e($statusColor[$transaksiRetur->status]); ?>"><?php echo e(ucfirst($transaksiRetur->status)); ?></span>
                        </td>
                    </tr>
                </table>
                <hr style="border-color: var(--sigma-border)">
                <small class="text-muted d-block">Alasan Retur:</small>
                <p class="mb-2"><?php echo e($transaksiRetur->alasan_retur); ?></p>
                <?php if($transaksiRetur->keterangan): ?>
                <small class="text-muted d-block">Keterangan:</small>
                <p class="mb-0"><?php echo e($transaksiRetur->keterangan); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Daftar Barang Retur</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>No. Batch</th>
                                <th class="text-center">Qty Retur</th>
                                <th class="text-center">Kondisi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transaksiRetur->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($item->varianProduk->nomor_sku); ?></span></td>
                                <td class="fw-semibold"><?php echo e($item->varianProduk->produk->nama_produk); ?> - <?php echo e($item->varianProduk->nama_varian); ?></td>
                                <td><?php echo e($item->nomor_batch ?? '-'); ?></td>
                                <td class="text-center fw-bold"><?php echo e($item->qty_retur); ?></td>
                                <td class="text-center">
                                    <?php $kondisiColor = ['baik'=>'success','rusak'=>'danger','cacat'=>'warning','kadaluarsa'=>'secondary']; ?>
                                    <span class="badge bg-<?php echo e($kondisiColor[$item->kondisi_barang]); ?>"><?php echo e(ucfirst($item->kondisi_barang)); ?></span>
                                </td>
                                <td><?php echo e($item->keterangan_kondisi ?? '-'); ?></td>
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

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/transaksi-retur/show.blade.php ENDPATH**/ ?>