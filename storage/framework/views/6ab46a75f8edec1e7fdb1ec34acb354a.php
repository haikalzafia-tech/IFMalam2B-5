<div class="card h-100" style="box-shadow: var(--sigma-shadow-soft) !important;">
    <div class="card-body">
        <?php if($varian->gambar_varian): ?>
        <img src="<?php echo e(asset('storage/varian-produk/'. $varian->gambar_varian)); ?>" alt="<?php echo e($varian->nama_varian); ?>"
            class="img-fluid mb-2 rounded" style="height: 150px; object-fit: cover; width: 100%;">
        <?php else: ?>
        <div class="d-flex align-items-center justify-content-center mb-2 rounded" style="height: 150px; background: var(--sigma-bg);">
            <i class="fas fa-image fa-2x opacity-25"></i>
        </div>
        <?php endif; ?>
        <h6 class="fw-bold mb-2" style="color: var(--sigma-navy-900)"><?php echo e($varian->nama_varian); ?></h6>

        <div class="small mb-1">
            <span class="text-muted">SKU:</span> <span class="fw-semibold"><?php echo e($varian->nomor_sku); ?></span>
        </div>
        <div class="small mb-1">
            <span class="text-muted">Lokasi:</span> <span class="fw-semibold"><?php echo e($varian->lokas_lengkap); ?></span>
        </div>
        <div class="small mb-2">
            <span class="text-muted">Stok:</span> <span class="fw-semibold"><?php echo e(number_format($varian->stok_varian)); ?> pcs</span>
        </div>

        <?php if($varian->stok_varian <= 0): ?>
        <span class="badge bg-danger">Stok Habis</span>
        <?php elseif($varian->stok_varian < ($varian->produk->stok_minimum ?? 0)): ?>
        <span class="badge bg-warning">Stok Menipis</span>
        <?php endif; ?>
    </div>

    <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
        <div class="card-footer d-flex gap-2 p-2" style="background: var(--sigma-bg); border-top: 1px solid var(--sigma-border);">
            <button type="button" class="btn btn-outline-primary btn-xs flex-grow-1 btnEditVarian" data-id="<?php echo e($varian->id); ?>"
                data-nama-varian="<?php echo e($varian->nama_varian); ?>"
                data-rak-id="<?php echo e($varian->rak_id); ?>"
                data-stok-varian="<?php echo e($varian->stok_varian); ?>"
                data-berat="<?php echo e($varian->berat); ?>"
                data-dimensi="<?php echo e($varian->dimensi); ?>"
                data-action="<?php echo e(route('master-data.varian-produk.update', $varian->id)); ?>">
                <i class="fas fa-edit"></i> Edit
            </button>
            <form action="<?php echo e(route('master-data.varian-produk.destroy', $varian->id)); ?>" method="POST" class="formDeleteVarian">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    <?php else: ?>
        <div class="card-footer p-2 text-center" style="background: var(--sigma-bg); border-top: 1px solid var(--sigma-border);">
            <small class="text-muted"><i class="fas fa-lock me-1"></i> Terkunci (Admin)</small>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/components/produk/card-varian.blade.php ENDPATH**/ ?>