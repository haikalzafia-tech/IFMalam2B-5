<?php $__env->startSection('page_title', $pageTitle); ?>
<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Data Barang</h4>
        <div class="d-flex gap-2">
            <?php if (isset($component)) { $__componentOriginal5b2ec28abcaebf2b210103da093a5e1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c = $attributes; } ?>
<?php $component = App\View\Components\Produk\FormProduk::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('produk.form-produk'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Produk\FormProduk::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c)): ?>
<?php $attributes = $__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c; ?>
<?php unset($__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b2ec28abcaebf2b210103da093a5e1c)): ?>
<?php $component = $__componentOriginal5b2ec28abcaebf2b210103da093a5e1c; ?>
<?php unset($__componentOriginal5b2ec28abcaebf2b210103da093a5e1c); ?>
<?php endif; ?>
        </div>
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
            <div class="col-12 col-md-8">
                <?php if (isset($component)) { $__componentOriginal37f8fc39859fb17caddc65202dec1208 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37f8fc39859fb17caddc65202dec1208 = $attributes; } ?>
<?php $component = App\View\Components\FilterByField::resolve(['term' => 'search','placeholder' => 'Cari nama barang...'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filter-by-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FilterByField::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal37f8fc39859fb17caddc65202dec1208)): ?>
<?php $attributes = $__attributesOriginal37f8fc39859fb17caddc65202dec1208; ?>
<?php unset($__attributesOriginal37f8fc39859fb17caddc65202dec1208); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal37f8fc39859fb17caddc65202dec1208)): ?>
<?php $component = $__componentOriginal37f8fc39859fb17caddc65202dec1208; ?>
<?php unset($__componentOriginal37f8fc39859fb17caddc65202dec1208); ?>
<?php endif; ?>
            </div>
            <div class="col-6 col-md-2">
                <?php if (isset($component)) { $__componentOriginal76f74df0a4c83b23d505b23851b14571 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal76f74df0a4c83b23d505b23851b14571 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button-reset-filter','data' => ['route' => 'master-data.produk.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-reset-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'master-data.produk.index']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal76f74df0a4c83b23d505b23851b14571)): ?>
<?php $attributes = $__attributesOriginal76f74df0a4c83b23d505b23851b14571; ?>
<?php unset($__attributesOriginal76f74df0a4c83b23d505b23851b14571); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal76f74df0a4c83b23d505b23851b14571)): ?>
<?php $component = $__componentOriginal76f74df0a4c83b23d505b23851b14571; ?>
<?php unset($__componentOriginal76f74df0a4c83b23d505b23851b14571); ?>
<?php endif; ?>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px">No</th>
                        <th>Barang</th>
                        <th>Kategori</th>
                        <th class="text-center">Total Stok</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $totalStok = $item->varianProduks->sum('stok_varian');
                        $statusStok = $totalStok <= 0 ? 'danger' : ($totalStok < $item->stok_minimum ? 'warning' : 'success');
                    ?>
                    <tr>
                        <td class="text-muted"><?php echo e($produk->firstItem() + $index); ?></td>
                        <td>
                            <a href="<?php echo e(route('master-data.produk.show', $item->id)); ?>" class="fw-semibold text-decoration-none" style="color: var(--sigma-navy-700)">
                                <?php echo e($item->nama_produk); ?>

                            </a>
                            <br><small class="text-muted"><?php echo e($item->kode_produk); ?></small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                <?php echo e($item->kategoriProduk?->nama_kategori ?? 'Tanpa Kategori'); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-<?php echo e($statusStok); ?>">
                                <?php echo e(number_format($totalStok)); ?> <?php echo e($item->satuan); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <?php if (isset($component)) { $__componentOriginal5b2ec28abcaebf2b210103da093a5e1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c = $attributes; } ?>
<?php $component = App\View\Components\Produk\FormProduk::resolve(['id' => ''.e($item->id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('produk.form-produk'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Produk\FormProduk::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c)): ?>
<?php $attributes = $__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c; ?>
<?php unset($__attributesOriginal5b2ec28abcaebf2b210103da093a5e1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b2ec28abcaebf2b210103da093a5e1c)): ?>
<?php $component = $__componentOriginal5b2ec28abcaebf2b210103da093a5e1c; ?>
<?php unset($__componentOriginal5b2ec28abcaebf2b210103da093a5e1c); ?>
<?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-boxes fa-2x text-muted mb-2 d-block opacity-50"></i>
                            <span class="text-muted">Data barang tidak tersedia</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
            <p class="text-muted small mb-0">
                Menampilkan <?php echo e($produk->firstItem()); ?> sampai <?php echo e($produk->lastItem()); ?> dari <?php echo e($produk->total()); ?> produk
            </p>
            <?php echo e($produk->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/produk/index.blade.php ENDPATH**/ ?>