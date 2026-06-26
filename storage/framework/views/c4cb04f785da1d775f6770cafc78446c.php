<?php $__env->startSection('page_title', 'Detail Supplier'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Supplier</h4>
                <a href="<?php echo e(route('master-data.supplier.index')); ?>" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">Kode</td><td><span class="badge bg-secondary"><?php echo e($supplier->kode_supplier); ?></span></td></tr>
                    <tr><td class="text-muted">Nama</td><td><strong><?php echo e($supplier->nama_supplier); ?></strong></td></tr>
                    <tr><td class="text-muted">Jenis</td><td><span class="badge bg-info"><?php echo e(ucfirst($supplier->jenis_supplier)); ?></span></td></tr>
                    <tr><td class="text-muted">Alamat</td><td><?php echo e($supplier->alamat); ?></td></tr>
                    <tr><td class="text-muted">Kota</td><td><?php echo e($supplier->kota); ?>, <?php echo e($supplier->provinsi); ?> <?php echo e($supplier->kode_pos); ?></td></tr>
                    <tr><td class="text-muted">NPWP</td><td><?php echo e($supplier->npwp ?? '-'); ?></td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge bg-<?php echo e($supplier->status == 'aktif' ? 'success' : 'danger'); ?>"><?php echo e(ucfirst($supplier->status)); ?></span></td>
                    </tr>
                </table>
                <hr>
                <h6 class="text-muted">Penanggung Jawab</h6>
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">Nama</td><td><?php echo e($supplier->pic_nama); ?></td></tr>
                    <tr><td class="text-muted">Jabatan</td><td><?php echo e($supplier->pic_jabatan ?? '-'); ?></td></tr>
                    <tr><td class="text-muted">Telepon</td><td><?php echo e($supplier->telepon); ?></td></tr>
                    <tr><td class="text-muted">Email</td><td><?php echo e($supplier->email ?? '-'); ?></td></tr>
                </table>
                <a href="<?php echo e(route('master-data.supplier.edit', $supplier)); ?>" class="btn btn-warning btn-sm w-100 mt-2">
                    <i class="fas fa-edit me-1"></i> Edit Supplier
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Riwayat Transaksi Terbaru</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Nomor Transaksi</th>
                                <th>Tanggal</th>
                                <th>Jumlah Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $supplier->transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($transaksi->nomor_transaksi); ?></td>
                                <td><?php echo e($transaksi->tanggal_transaksi->format('d/m/Y')); ?></td>
                                <td><?php echo e($transaksi->jumlah_barang); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($transaksi->status == 'selesai' ? 'success' : 'warning'); ?>">
                                        <?php echo e(ucfirst($transaksi->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('transaksi-masuk.show', $transaksi)); ?>" class="btn btn-xs btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi dengan supplier ini.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header"><h4 class="card-title">Riwayat Retur</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Nomor Retur</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Alasan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $supplier->transaksiReturs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($retur->nomor_retur); ?></td>
                                <td><?php echo e($retur->tanggal_retur->format('d/m/Y')); ?></td>
                                <td><?php echo e(str_replace('_', ' ', ucfirst($retur->jenis_retur))); ?></td>
                                <td><?php echo e(Str::limit($retur->alasan_retur, 40)); ?></td>
                                <td><span class="badge bg-<?php echo e($retur->status == 'selesai' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst($retur->status)); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted">Belum ada retur dengan supplier ini.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\ini baru\resources\views/supplier/show.blade.php ENDPATH**/ ?>