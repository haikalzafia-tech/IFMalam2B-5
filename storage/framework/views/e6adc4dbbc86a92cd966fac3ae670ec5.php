<?php $__env->startSection('page_title', $pageTitle); ?>
<?php $__env->startSection('content'); ?>

<style>
    .page-inner {
        background: #f8f9fa;
        min-height: 100vh;
    }

    .main-card-3d {
        border: none !important;
        border-radius: 20px !important;
        background: #f8f9fa;
        box-shadow: 10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff !important;
        padding: 10px;
    }

    .filter-wrapper {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
    }

    .custom-table thead th {
        background: transparent;
        border-bottom: 2px solid #eef0f2 !important;
        color: #495057;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 15px !important;
    }

    .custom-table tbody tr {
        transition: all 0.3s ease;
    }

    .custom-table tbody tr:hover {
        background: #ffffff !important;
        transform: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .custom-table td {
        padding: 18px 15px !important;
        vertical-align: middle !important;
        border: none !important;
    }

    .badge-number {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 8px;
        box-shadow: 3px 3px 6px #d1d9e6, -3px -3px 6px #ffffff;
        font-weight: bold;
        color: #1a73e8;
    }

    .kode-pill {
        background: #eef0f2;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #6c757d;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    .jumlah-produk-pill {
        background: rgba(26, 115, 232, 0.08);
        color: #1a73e8;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .action-btn-wrapper {
        display: flex;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .filter-wrapper .row > div {
            margin-bottom: 12px;
        }
        .page-inner { padding: 10px !important; }
        .main-card-3d { border-radius: 15px !important; }
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="card main-card-3d">
            <div class="card-body">

                <div class="filter-wrapper">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-9">
                            <div class="row g-2">
                                <div class="col-4 col-md-2">
                                   
                                </div>
                                <div class="col-6 col-md-9">
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
                                <div class="col-2 col-md-1">
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
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-md-end text-center mt-3 mt-md-0">
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
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 70px">No</th>
                                <th style="width: 130px">Kode</th>
                                <th>Nama Kategori</th>
                                <th class="text-center" style="width: 140px">Jumlah Barang</th>
                                <th class="text-center" style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <div class="badge-number mx-auto">
                                        <?php echo e($kategori->firstItem() + $index); ?>

                                    </div>
                                </td>
                                <td><span class="kode-pill"><?php echo e($item->kode_kategori); ?></span></td>
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 15px;"><?php echo e($item->nama_kategori); ?></span>
                                    <?php if($item->deskripsi): ?>
                                    <br><small class="text-muted"><?php echo e(Str::limit($item->deskripsi, 50)); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="jumlah-produk-pill"><?php echo e($item->produks_count); ?> barang</span>
                                </td>
                                <td>
                                    <div class="action-btn-wrapper justify-content-center">
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
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                                    <p class="text-muted">Data kategori belum tersedia</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <p class="text-muted small mb-3 mb-md-0">
                        Menampilkan <?php echo e($kategori->firstItem()); ?> sampai <?php echo e($kategori->lastItem()); ?> dari <?php echo e($kategori->total()); ?> data
                    </p>
                    <div class="pagination-3d">
                        <?php echo e($kategori->links()); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\ini baru\resources\views/kategori-produk/index.blade.php ENDPATH**/ ?>