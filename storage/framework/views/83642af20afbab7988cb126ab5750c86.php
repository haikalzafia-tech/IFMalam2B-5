<?php $__env->startSection('page_title', $pageTitle); ?>
<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Kategori Barang</h4>
        <?php if (isset($component)) { $__componentOriginal5793cacedaf55c8251cf9ecce4818b36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5793cacedaf55c8251cf9ecce4818b36 = $attributes; } ?>
<?php $component = App\View\Components\KategoriProduk\FormKategoriProduk::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kategori-produk.form-kategori-produk'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\KategoriProduk\FormKategoriProduk::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5793cacedaf55c8251cf9ecce4818b36)): ?>
<?php $attributes = $__attributesOriginal5793cacedaf55c8251cf9ecce4818b36; ?>
<?php unset($__attributesOriginal5793cacedaf55c8251cf9ecce4818b36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5793cacedaf55c8251cf9ecce4818b36)): ?>
<?php $component = $__componentOriginal5793cacedaf55c8251cf9ecce4818b36; ?>
<?php unset($__componentOriginal5793cacedaf55c8251cf9ecce4818b36); ?>
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
            <div class="col-12 col-md-8">
                <?php if (isset($component)) { $__componentOriginal37f8fc39859fb17caddc65202dec1208 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37f8fc39859fb17caddc65202dec1208 = $attributes; } ?>
<?php $component = App\View\Components\FilterByField::resolve(['term' => 'search','placeholder' => 'Cari kategori barang...'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button-reset-filter','data' => ['route' => 'master-data.kategori-produk.index']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-reset-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'master-data.kategori-produk.index']); ?>
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
                        <th style="width: 120px">Kode</th>
                        <th>Nama Kategori</th>
                        <th class="text-center" style="width: 130px">Jumlah Barang</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($kategori->firstItem() + $index); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($item->kode_kategori); ?></span></td>
                        <td>
                            <span class="fw-semibold" style="color: var(--sigma-navy-900)"><?php echo e($item->nama_kategori); ?></span>
                            <?php if($item->deskripsi): ?>
                            <br><small class="text-muted"><?php echo e(Str::limit($item->deskripsi, 50)); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info"><?php echo e($item->produks_count); ?> barang</span>
                        </td>
                        <td class="text-center">
                            <?php if (isset($component)) { $__componentOriginal5793cacedaf55c8251cf9ecce4818b36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5793cacedaf55c8251cf9ecce4818b36 = $attributes; } ?>
<?php $component = App\View\Components\KategoriProduk\FormKategoriProduk::resolve(['id' => ''.e($item->id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kategori-produk.form-kategori-produk'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\KategoriProduk\FormKategoriProduk::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['nama_kategori' => ''.e($item->nama_kategori).'','deskripsi' => ''.e($item->deskripsi).'','action' => ''.e(route('master-data.kategori-produk.update', $item->id)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5793cacedaf55c8251cf9ecce4818b36)): ?>
<?php $attributes = $__attributesOriginal5793cacedaf55c8251cf9ecce4818b36; ?>
<?php unset($__attributesOriginal5793cacedaf55c8251cf9ecce4818b36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5793cacedaf55c8251cf9ecce4818b36)): ?>
<?php $component = $__componentOriginal5793cacedaf55c8251cf9ecce4818b36; ?>
<?php unset($__componentOriginal5793cacedaf55c8251cf9ecce4818b36); ?>
<?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-inbox fa-2x text-muted mb-2 d-block opacity-50"></i>
                            <span class="text-muted">Data kategori belum tersedia</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
            <p class="text-muted small mb-0">
                Menampilkan <?php echo e($kategori->firstItem()); ?> sampai <?php echo e($kategori->lastItem()); ?> dari <?php echo e($kategori->total()); ?> data
            </p>
            <?php echo e($kategori->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/kategori-produk/index.blade.php ENDPATH**/ ?>