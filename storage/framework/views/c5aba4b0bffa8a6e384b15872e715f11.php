<?php $__env->startSection('page_title', 'Kelola Lokasi Stok'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Distribusi Stok per Rak</h4>
        <p class="text-muted small mb-0">Kelola di rak mana saja stok suatu barang berada, terutama untuk barang yang tersebar di lebih dari satu rak.</p>
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
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama barang / SKU..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th class="text-center">Total Stok</th>
                        <th class="text-center">Jumlah Lokasi</th>
                        <th>Rincian Lokasi</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $varianProduks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?php echo e($v->nomor_sku); ?></span></td>
                        <td class="fw-semibold"><?php echo e($v->produk->nama_produk); ?> - <?php echo e($v->nama_varian); ?></td>
                        <td class="text-center fw-bold"><?php echo e($v->stok_varian); ?></td>
                        <td class="text-center">
                            <span class="badge bg-<?php echo e($v->lokasiStoks->count() > 1 ? 'info' : 'secondary'); ?>">
                                <?php echo e($v->lokasiStoks->count()); ?> rak
                            </span>
                        </td>
                        <td>
                            <?php $__empty_2 = true; $__currentLoopData = $v->lokasiStoks->where('qty', '>', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <span class="badge bg-secondary me-1 mb-1">
                                    <?php echo e($lokasi->rak->kode_rak ?? '-'); ?>: <?php echo e($lokasi->qty); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <span class="text-muted small">Belum ada lokasi</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo e(route('lokasi-stok.edit', $v)); ?>" class="btn btn-xs btn-warning">
                                <i class="fas fa-map-marker-alt me-1"></i> Atur
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada data barang.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($varianProduks->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/lokasi-stok/index.blade.php ENDPATH**/ ?>