<?php $__env->startSection('page_title', 'Detail Gudang'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3">
    
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Gudang</h4>
                <a href="<?php echo e(route('master-data.gudang.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-2">
                    <tr><td class="text-muted">Kode</td><td><span class="badge bg-secondary"><?php echo e($gudang->kode_gudang); ?></span></td></tr>
                    <tr><td class="text-muted">Nama</td><td class="fw-semibold"><?php echo e($gudang->nama_gudang); ?></td></tr>
                    <tr><td class="text-muted">Alamat</td><td><?php echo e($gudang->alamat); ?></td></tr>
                    <tr><td class="text-muted">Kota</td><td><?php echo e($gudang->kota); ?>, <?php echo e($gudang->provinsi); ?></td></tr>
                    <tr><td class="text-muted">PIC</td><td><?php echo e($gudang->pic_nama); ?></td></tr>
                    <tr><td class="text-muted">Telepon</td><td><?php echo e($gudang->pic_telepon ?? '-'); ?></td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge bg-<?php echo e($gudang->status == 'aktif' ? 'success' : 'danger'); ?>"><?php echo e(ucfirst($gudang->status)); ?></span></td>
                    </tr>
                </table>

                
                <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                    <a href="<?php echo e(route('master-data.gudang.edit', $gudang)); ?>" class="btn btn-warning btn-sm w-100">
                        <i class="fas fa-edit me-1"></i> Edit Gudang
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h4 class="card-title">Kapasitas Gudang</h4></div>
            <div class="card-body text-center">
                <h2 class="fw-bold mb-1" style="color: var(--sigma-<?php echo e($persentase >= 90 ? 'danger' : ($persentase >= 70 ? 'warning' : 'success')); ?>)">
                    <?php echo e($persentase); ?>%
                </h2>
                <p class="text-muted small mb-3">Terpakai</p>
                <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar bg-<?php echo e($persentase >= 90 ? 'danger' : ($persentase >= 70 ? 'warning' : 'success')); ?>"
                        style="width: <?php echo e($persentase); ?>%"></div>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="fw-bold mb-0"><?php echo e(number_format($totalTerpakai)); ?></h5>
                        <small class="text-muted">Terpakai</small>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold mb-0"><?php echo e(number_format($totalKapasitas)); ?></h5>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Layout Zona & Rak</h4>

                
                <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                    <a href="<?php echo e(route('master-data.zona.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Zona
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $gudang->zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-4 <?php echo e(!$loop->last ? 'pb-3 border-bottom' : ''); ?>">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">
                            <span class="badge bg-primary me-2"><?php echo e($zona->kode_zona); ?></span>
                            <span class="fw-semibold"><?php echo e($zona->nama_zona); ?></span>
                            <small class="text-muted ms-1">(<?php echo e(ucfirst($zona->jenis_zona)); ?>)</small>
                        </h6>
                        <span class="badge bg-<?php echo e($zona->status == 'aktif' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($zona->status)); ?></span>
                    </div>

                    <?php if($zona->raks->count() > 0): ?>
                    <div class="row g-2">
                        <?php $__currentLoopData = $zona->raks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; ?>
                        <div class="col-sm-6 col-lg-4">
                            <div class="border rounded-3 p-2" style="border-color: var(--sigma-border) !important;">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong class="small"><?php echo e($rak->kode_rak); ?></strong>
                                    <span class="badge bg-<?php echo e($rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($rak->status)); ?>

                                    </span>
                                </div>
                                <small class="text-muted d-block mb-1"><?php echo e($rak->nama_rak); ?></small>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-<?php echo e($persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success')); ?>"
                                        style="width: <?php echo e($persen); ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo e($rak->kapasitas_terpakai); ?>/<?php echo e($rak->kapasitas_total); ?> (<?php echo e($persen); ?>%)</small>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php else: ?>
                    
                    <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                        <p class="text-muted small ms-1 mb-0">Belum ada rak di zona ini.
                            <a href="<?php echo e(route('master-data.rak.create')); ?>">Tambah rak</a>
                        </p>
                    <?php else: ?>
                        <p class="text-muted small ms-1 mb-0">Belum ada rak di zona ini.</p>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-muted py-4 mb-0">Belum ada zona.
                    <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                        <a href="<?php echo e(route('master-data.zona.create')); ?>">Tambah zona pertama</a>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/gudang/show.blade.php ENDPATH**/ ?>