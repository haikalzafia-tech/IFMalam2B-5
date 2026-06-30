<?php $__env->startSection('page_title', 'Transaksi Keluar'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h4 class="card-title">Daftar Transaksi Keluar</h4>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalExport">
                <i class="fas fa-file-excel me-1"></i> Export
            </button>

            
            <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                <a href="<?php echo e(route('transaksi-keluar.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Transaksi Baru
                </a>
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
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nomor transaksi..." value="<?php echo e(request('search')); ?>">
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
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="diproses" <?php echo e(request('status') == 'diproses' ? 'selected' : ''); ?>>Diproses</option>
                    <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                    <option value="dibatalkan" <?php echo e(request('status') == 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Penerima</th>
                        <th>Tujuan</th>
                        <th class="text-center">Jml Barang</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 90px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($transaksis->firstItem() + $loop->index); ?></td>
                        <td><span class="badge bg-primary"><?php echo e($t->nomor_transaksi); ?></span></td>
                        <td><?php echo e($t->tanggal_transaksi->format('d/m/Y')); ?></td>
                        <td><?php echo e($t->gudang->nama_gudang); ?></td>
                        <td><?php echo e($t->penerima); ?></td>
                        <td><?php echo e($t->tujuan ?? '-'); ?></td>
                        <td class="text-center fw-semibold"><?php echo e($t->jumlah_barang); ?></td>
                        <td class="text-center">
                            <?php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; ?>
                            <span class="badge bg-<?php echo e($statusColor[$t->status]); ?>"><?php echo e(ucfirst($t->status)); ?></span>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo e(route('transaksi-keluar.show', $t)); ?>" class="btn btn-xs btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9" class="text-center text-muted py-5">Belum ada transaksi keluar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($transaksis->links()); ?></div>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginal298e4bd81774a252458e6ac6784dd2ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal298e4bd81774a252458e6ac6784dd2ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-modal','data' => ['route' => 'export.transaksi-keluar','judul' => 'Export Transaksi Keluar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('export-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'export.transaksi-keluar','judul' => 'Export Transaksi Keluar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal298e4bd81774a252458e6ac6784dd2ba)): ?>
<?php $attributes = $__attributesOriginal298e4bd81774a252458e6ac6784dd2ba; ?>
<?php unset($__attributesOriginal298e4bd81774a252458e6ac6784dd2ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal298e4bd81774a252458e6ac6784dd2ba)): ?>
<?php $component = $__componentOriginal298e4bd81774a252458e6ac6784dd2ba; ?>
<?php unset($__componentOriginal298e4bd81774a252458e6ac6784dd2ba); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/transaksi-keluar/index.blade.php ENDPATH**/ ?>