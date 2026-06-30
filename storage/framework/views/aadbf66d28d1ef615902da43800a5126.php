<?php $__env->startSection('page_title', 'Data Rak'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Rak Gudang</h4>

        
        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
            <a href="<?php echo e(route('master-data.rak.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Rak
            </a>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <?php if (isset($component)) { $__componentOriginal18e7e86833d3c3850dccc63d62d1bf2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18e7e86833d3c3850dccc63d62d1bf2e = $attributes; } ?>
<?php $component = App\View\Components\PerPageOption::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('per-page-option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PerPageOption::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18e7e86833d3c3850dccc63d62d1bf2e)): ?>
<?php $attributes = $__attributesOriginal18e7e86833d3c3850dccc63d62d1bf2e; ?>
<?php unset($__attributesOriginal18e7e86833d3c3850dccc63d62d1bf2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18e7e86833d3c3850dccc63d62d1bf2e)): ?>
<?php $component = $__componentOriginal18e7e86833d3c3850dccc63d62d1bf2e; ?>
<?php unset($__componentOriginal18e7e86833d3c3850dccc63d62d1bf2e); ?>
<?php endif; ?>
            </div>
            <div class="col-6 col-md-3">
                <select name="gudang_id" class="form-select form-select-sm">
                    <option value="">-- Semua Gudang --</option>
                    <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g->id); ?>" <?php echo e(request('gudang_id') == $g->id ? 'selected' : ''); ?>><?php echo e($g->nama_gudang); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="zona_id" class="form-select form-select-sm">
                    <option value="">-- Semua Zona --</option>
                    <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($z->id); ?>" <?php echo e(request('zona_id') == $z->id ? 'selected' : ''); ?>>
                        <?php echo e($z->gudang->nama_gudang); ?> - <?php echo e($z->nama_zona); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" <?php echo e(request('status') == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="penuh" <?php echo e(request('status') == 'penuh' ? 'selected' : ''); ?>>Penuh</option>
                    <option value="nonaktif" <?php echo e(request('status') == 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Kode Rak</th>
                        <th>Nama Rak</th>
                        <th>Zona</th>
                        <th>Gudang</th>
                        <th>Kapasitas</th>
                        <th>Terpakai</th>
                        <th class="text-center">Status</th>

                        
                        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                            <th class="text-center" style="width: 130px">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $raks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $persen = $rak->kapasitas_total > 0 ? round(($rak->kapasitas_terpakai / $rak->kapasitas_total) * 100) : 0; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($raks->firstItem() + $loop->index); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($rak->kode_rak); ?></span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)"><?php echo e($rak->nama_rak); ?></td>
                        <td><?php echo e($rak->zona->nama_zona); ?></td>
                        <td><?php echo e($rak->zona->gudang->nama_gudang); ?></td>
                        <td><?php echo e(number_format($rak->kapasitas_total)); ?></td>
                        <td style="min-width: 130px;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:7px;">
                                    <div class="progress-bar bg-<?php echo e($persen >= 90 ? 'danger' : ($persen >= 70 ? 'warning' : 'success')); ?>"
                                        style="width:<?php echo e($persen); ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo e($persen); ?>%</small>
                            </div>
                            <small class="text-muted"><?php echo e($rak->kapasitas_terpakai); ?>/<?php echo e($rak->kapasitas_total); ?></small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-<?php echo e($rak->status == 'aktif' ? 'success' : ($rak->status == 'penuh' ? 'danger' : 'secondary')); ?>">
                                <?php echo e(ucfirst($rak->status)); ?>

                            </span>
                        </td>

                        
                        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="<?php echo e(route('master-data.rak.show', $rak)); ?>" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo e(route('master-data.rak.edit', $rak)); ?>" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-rak-<?php echo e($rak->id); ?>" action="<?php echo e(route('master-data.rak.destroy', $rak)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="SigmaNotif.konfirmasiHapus('delete-rak-<?php echo e($rak->id); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="<?php echo e(Auth::check() && Auth::user()->role == 'admin' ? 9 : 8); ?>" class="text-center text-muted py-5">Belum ada data rak.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($raks->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/rak/index.blade.php ENDPATH**/ ?>