<?php $__env->startSection('page_title', 'Edit Gudang'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Gudang: <?php echo e($gudang->nama_gudang); ?></h4>
                <a href="<?php echo e(route('master-data.gudang.index')); ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
                <?php endif; ?>

                <form action="<?php echo e(route('master-data.gudang.update', $gudang)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_gudang" class="form-control <?php $__errorArgs = ['nama_gudang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nama_gudang', $gudang->nama_gudang)); ?>" required>
                            <?php $__errorArgs = ['nama_gudang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required><?php echo e(old('alamat', $gudang->alamat)); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control" value="<?php echo e(old('kota', $gudang->kota)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control" value="<?php echo e(old('provinsi', $gudang->provinsi)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama PIC <span class="text-danger">*</span></label>
                            <input type="text" name="pic_nama" class="form-control" value="<?php echo e(old('pic_nama', $gudang->pic_nama)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telepon PIC</label>
                            <input type="text" name="pic_telepon" class="form-control" value="<?php echo e(old('pic_telepon', $gudang->pic_telepon)); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="aktif" <?php echo e($gudang->status == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                                <option value="nonaktif" <?php echo e($gudang->status == 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"><?php echo e(old('keterangan', $gudang->keterangan)); ?></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('<?php echo e(route('master-data.gudang.index')); ?>')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\ini baru\resources\views/gudang/edit.blade.php ENDPATH**/ ?>