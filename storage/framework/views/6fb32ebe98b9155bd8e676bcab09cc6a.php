<?php $__env->startSection('page_title', 'Buat Stok Opname Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Stok Opname Baru</h4>
                <a href="<?php echo e(route('stok-opname.index')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Setelah dibuat, sistem akan otomatis menampilkan semua barang di gudang ini beserta stok sistemnya.
                    Anda tinggal mengisi stok fisik hasil hitung manual.
                </div>

                <form action="<?php echo e(route('stok-opname.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Gudang <span class="text-danger">*</span></label>
                            <select name="gudang_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g->id); ?>"><?php echo e($g->nama_gudang); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tanggal Opname <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_opname" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-play me-1"></i> Mulai Opname</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('<?php echo e(route('stok-opname.index')); ?>')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/stok-opname/create.blade.php ENDPATH**/ ?>