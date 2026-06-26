<?php $__env->startSection('page_title', 'Data Supplier'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Supplier</h4>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('export.supplier')); ?>" class="btn btn-success btn-sm" title="Export ke Excel">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                    <a href="<?php echo e(route('master-data.supplier.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Supplier
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-2">
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
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari nama / kode supplier..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="jenis" class="form-select form-select-sm">
                            <option value="">-- Semua Jenis --</option>
                            <option value="produsen" <?php echo e(request('jenis') == 'produsen' ? 'selected' : ''); ?>>Produsen</option>
                            <option value="distributor" <?php echo e(request('jenis') == 'distributor' ? 'selected' : ''); ?>>Distributor</option>
                            <option value="agen" <?php echo e(request('jenis') == 'agen' ? 'selected' : ''); ?>>Agen</option>
                            <option value="retailer" <?php echo e(request('jenis') == 'retailer' ? 'selected' : ''); ?>>Retailer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="aktif" <?php echo e(request('status') == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                            <option value="nonaktif" <?php echo e(request('status') == 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-secondary w-100">Filter</button>
                    </div>
                    <?php if(request()->anyFilled(['search','jenis','status'])): ?>
                    <div class="col-md-1">
                        <a href="<?php echo e(route('master-data.supplier.index')); ?>" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                    <?php endif; ?>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Supplier</th>
                                <th>Jenis</th>
                                <th>PIC</th>
                                <th>Telepon</th>
                                <th>Kota</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($suppliers->firstItem() + $loop->index); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($supplier->kode_supplier); ?></span></td>
                                <td><?php echo e($supplier->nama_supplier); ?></td>
                                <td><span class="badge bg-info"><?php echo e(ucfirst($supplier->jenis_supplier)); ?></span></td>
                                <td><?php echo e($supplier->pic_nama); ?></td>
                                <td><?php echo e($supplier->telepon); ?></td>
                                <td><?php echo e($supplier->kota); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($supplier->status == 'aktif' ? 'success' : 'danger'); ?>">
                                        <?php echo e(ucfirst($supplier->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('master-data.supplier.show', $supplier)); ?>" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo e(route('master-data.supplier.edit', $supplier)); ?>" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="delete-supplier-<?php echo e($supplier->id); ?>" action="<?php echo e(route('master-data.supplier.destroy', $supplier)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <button type="button" class="btn btn-xs btn-danger"
                                        onclick="SigmaNotif.konfirmasiHapus('delete-supplier-<?php echo e($supplier->id); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="9" class="text-center text-muted">Belum ada data supplier.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($suppliers->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\ini baru\resources\views/supplier/index.blade.php ENDPATH**/ ?>