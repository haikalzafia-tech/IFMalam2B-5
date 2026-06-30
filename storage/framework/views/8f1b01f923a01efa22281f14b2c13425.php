<?php $__env->startSection('page_title', 'Stok Opname'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Stok Opname</h4>

        
        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
            <a href="<?php echo e(route('stok-opname.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Buat Opname Baru
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
            <div class="col-6 col-md-4">
                <select name="gudang_id" class="form-select form-select-sm">
                    <option value="">-- Semua Gudang --</option>
                    <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g->id); ?>" <?php echo e(request('gudang_id') == $g->id ? 'selected' : ''); ?>><?php echo e($g->nama_gudang); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="berlangsung" <?php echo e(request('status') == 'berlangsung' ? 'selected' : ''); ?>>Berlangsung</option>
                    <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
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
                        <th>No. Opname</th>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Petugas</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $opnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($opnames->firstItem() + $loop->index); ?></td>
                        <td><span class="badge bg-primary"><?php echo e($o->nomor_opname); ?></span></td>
                        <td><?php echo e($o->tanggal_opname->format('d/m/Y')); ?></td>
                        <td><?php echo e($o->gudang->nama_gudang); ?></td>
                        <td><?php echo e($o->petugas); ?></td>
                        <td class="text-center">
                            <?php $statusColor = ['draft'=>'secondary','berlangsung'=>'warning','selesai'=>'success']; ?>
                            <span class="badge bg-<?php echo e($statusColor[$o->status]); ?>"><?php echo e(ucfirst($o->status)); ?></span>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo e(route('stok-opname.show', $o)); ?>" class="btn btn-xs btn-info">
                                <i class="fas fa-eye"></i> <?php echo e($o->status == 'berlangsung' ? 'Lanjutkan' : 'Detail'); ?>

                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada data stok opname.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($opnames->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/stok-opname/index.blade.php ENDPATH**/ ?>