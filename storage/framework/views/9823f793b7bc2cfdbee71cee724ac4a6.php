<?php $__env->startSection('page_title', 'Kartu Stok'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Kartu Stok - Log Pergerakan Barang</h4>
        <a href="<?php echo e(route('export.kartu-stok', request()->query())); ?>" class="btn btn-success btn-sm" title="Export sesuai filter yang aktif">
            <i class="fas fa-file-excel me-1"></i> Export
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="row g-2 mb-2">
                <div class="col-md-3 col-sm-4">
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
                <div class="col-md-5 col-sm-8">
                    <select name="nomor_sku" class="form-select form-select-sm select2">
                        <option value="">-- Semua Barang --</option>
                        <?php $__currentLoopData = $varianProduks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v->nomor_sku); ?>" <?php echo e(request('nomor_sku') == $v->nomor_sku ? 'selected' : ''); ?>>
                            <?php echo e($v->nomor_sku); ?> - <?php echo e($v->produk->nama_produk); ?> (<?php echo e($v->nama_varian); ?>)
                        </option>
                        <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($g->id); ?>" <?php echo e(request('gudang_id') == $g->id ? 'selected' : ''); ?>><?php echo e($g->nama_gudang); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <select name="gudang_id" class="form-select form-select-sm">
                        <option value="">-- Semua Gudang --</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-3 col-sm-12">
                    <select name="jenis_transaksi" class="form-select form-select-sm">
                        <option value="">-- Semua Jenis --</option>
                        <option value="in" <?php echo e(request('jenis_transaksi') == 'in' ? 'selected' : ''); ?>>Masuk</option>
                        <option value="out" <?php echo e(request('jenis_transaksi') == 'out' ? 'selected' : ''); ?>>Keluar</option>
                        <option value="retur" <?php echo e(request('jenis_transaksi') == 'retur' ? 'selected' : ''); ?>>Retur</option>
                        <option value="adjustment" <?php echo e(request('jenis_transaksi') == 'adjustment' ? 'selected' : ''); ?>>Adjustment</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="input-group input-group-sm">
                        <input type="date" name="dari" class="form-control" value="<?php echo e(request('dari')); ?>">
                        <span class="input-group-text bg-light text-muted">s/d</span>
                        <input type="date" name="sampai" class="form-control" value="<?php echo e(request('sampai')); ?>">
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <button type="submit" class="btn btn-secondary btn-sm w-100 fw-semibold">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th>Gudang</th>
                        <th>Rak</th>
                        <th>No. Transaksi</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Masuk</th>
                        <th class="text-center">Keluar</th>
                        <th class="text-center">Stok Akhir</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $kartuStoks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($k->created_at->format('d/m/Y H:i')); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($k->varianProduk->nomor_sku); ?></span></td>
                        <td class="fw-semibold"><?php echo e($k->varianProduk->produk->nama_produk); ?> - <?php echo e($k->varianProduk->nama_varian); ?></td>
                        <td><?php echo e($k->gudang->nama_gudang); ?></td>
                        <td><?php echo e($k->rak->kode_rak ?? '-'); ?></td>
                        <td><?php echo e($k->nomor_transaksi ?? '-'); ?></td>
                        <td class="text-center">
                            <?php
                                $jenisColor = ['in'=>'success','out'=>'danger','retur'=>'warning','adjustment'=>'info','transfer'=>'primary'];
                                $jenisLabel = ['in'=>'Masuk','out'=>'Keluar','retur'=>'Retur','adjustment'=>'Adjustment','transfer'=>'Transfer'];
                            ?>
                            <span class="badge bg-<?php echo e($jenisColor[$k->jenis_transaksi]); ?>"><?php echo e($jenisLabel[$k->jenis_transaksi]); ?></span>
                        </td>
                        <td class="text-center" style="color: var(--sigma-success)"><?php echo e($k->jumlah_masuk > 0 ? '+'.$k->jumlah_masuk : '-'); ?></td>
                        <td class="text-center" style="color: var(--sigma-danger)"><?php echo e($k->jumlah_keluar > 0 ? '-'.$k->jumlah_keluar : '-'); ?></td>
                        <td class="text-center fw-bold"><?php echo e($k->stok_akhir); ?></td>
                        <td><?php echo e($k->petugas); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="11" class="text-center text-muted py-5">Belum ada data kartu stok.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($kartuStoks->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/kartu-stok/index.blade.php ENDPATH**/ ?>