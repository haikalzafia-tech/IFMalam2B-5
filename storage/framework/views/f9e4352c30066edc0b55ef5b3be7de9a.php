<?php $__env->startSection('page_title', 'Data Zona'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Zona</h4>

        
        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
            <a href="<?php echo e(route('master-data.zona.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Zona
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
            <div class="col-12 col-md-6">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama zona..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-6 col-md-2">
                <select name="gudang_id" class="form-select form-select-sm">
                    <option value="">-- Semua Gudang --</option>
                    <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g->id); ?>" <?php echo e(request('gudang_id') == $g->id ? 'selected' : ''); ?>><?php echo e($g->nama_gudang); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <th>Kode</th>
                        <th>Nama Zona</th>
                        <th>Gudang</th>
                        <th>Jenis</th>
                        <th class="text-center">Jumlah Rak</th>
                        <th class="text-center">Status</th>

                        
                        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                            <th class="text-center" style="width: 110px">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($zonas->firstItem() + $loop->index); ?></td>
                        <td><span class="badge bg-primary"><?php echo e($zona->kode_zona); ?></span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)"><?php echo e($zona->nama_zona); ?></td>
                        <td><?php echo e($zona->gudang->nama_gudang); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e(ucfirst($zona->jenis_zona)); ?></span></td>
                        <td class="text-center"><span class="badge bg-info"><?php echo e($zona->raks_count); ?> rak</span></td>
                        <td class="text-center">
                            <span class="badge bg-<?php echo e($zona->status == 'aktif' ? 'success' : 'danger'); ?>"><?php echo e(ucfirst($zona->status)); ?></span>
                        </td>

                        
                        <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="<?php echo e(route('master-data.zona.edit', $zona)); ?>" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-zona-<?php echo e($zona->id); ?>" action="<?php echo e(route('master-data.zona.destroy', $zona)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="SigmaNotif.konfirmasiHapus('delete-zona-<?php echo e($zona->id); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="<?php echo e(Auth::user()->role == 'admin' ? 8 : 7); ?>" class="text-center text-muted py-5">Belum ada data zona.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($zonas->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/zona/index.blade.php ENDPATH**/ ?>