<?php $__env->startSection('page_title', 'Data Gudang'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Gudang</h4>

        
        <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
        <a href="<?php echo e(route('master-data.gudang.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Gudang
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
                    placeholder="Cari nama / kode gudang..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" <?php echo e(request('status') == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="nonaktif" <?php echo e(request('status') == 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Kode</th>
                        <th>Nama Gudang</th>
                        <th>Kota</th>
                        <th>PIC</th>
                        <th class="text-center">Zona</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gudang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($gudangs->firstItem() + $loop->index); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($gudang->kode_gudang); ?></span></td>
                        <td class="fw-semibold" style="color: var(--sigma-navy-900)"><?php echo e($gudang->nama_gudang); ?></td>
                        <td><?php echo e($gudang->kota); ?>, <?php echo e($gudang->provinsi); ?></td>
                        <td><?php echo e($gudang->pic_nama); ?></td>
                        <td class="text-center"><span class="badge bg-info"><?php echo e($gudang->zonas_count); ?> zona</span></td>
                        <td class="text-center">
                            <span class="badge bg-<?php echo e($gudang->status == 'aktif' ? 'success' : 'danger'); ?>">
                                <?php echo e(ucfirst($gudang->status)); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                
                                <a href="<?php echo e(route('master-data.gudang.show', $gudang)); ?>" class="btn btn-xs btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                
                                <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('master-data.gudang.edit', $gudang)); ?>" class="btn btn-xs btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="delete-gudang-<?php echo e($gudang->id); ?>" action="<?php echo e(route('master-data.gudang.destroy', $gudang)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                </form>
                                <button type="button" class="btn btn-xs btn-danger" title="Hapus"
                                    onclick="SigmaNotif.konfirmasiHapus('delete-gudang-<?php echo e($gudang->id); ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="text-center text-muted py-5">Belum ada data gudang.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($gudangs->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/gudang/index.blade.php ENDPATH**/ ?>