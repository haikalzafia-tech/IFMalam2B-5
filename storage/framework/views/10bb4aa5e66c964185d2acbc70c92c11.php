<?php $__env->startSection('page_title', 'Tambah Zona'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Zona</h4>
                <a href="<?php echo e(route('master-data.zona.index')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
                <?php endif; ?>

                <form action="<?php echo e(route('master-data.zona.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Gudang <span class="text-danger">*</span></label>
                            <select name="gudang_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g->id); ?>" <?php echo e(old('gudang_id') == $g->id ? 'selected' : ''); ?>>
                                    <?php echo e($g->kode_gudang); ?> - <?php echo e($g->nama_gudang); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nama Zona <span class="text-danger">*</span></label>
                            <input type="text" name="nama_zona" class="form-control"
                                value="<?php echo e(old('nama_zona')); ?>" placeholder="Contoh: Zona Elektronik, Zona Bahan Baku" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Jenis Zona <span class="text-danger">*</span></label>
                            <select name="jenis_zona" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="reguler" <?php echo e(old('jenis_zona') == 'reguler' ? 'selected' : ''); ?>>Reguler</option>
                                <option value="dingin" <?php echo e(old('jenis_zona') == 'dingin' ? 'selected' : ''); ?>>Dingin (Cold Storage)</option>
                                <option value="berbahaya" <?php echo e(old('jenis_zona') == 'berbahaya' ? 'selected' : ''); ?>>Berbahaya (Hazmat)</option>
                                <option value="karantina" <?php echo e(old('jenis_zona') == 'karantina' ? 'selected' : ''); ?>>Karantina</option>
                                <option value="ekspedisi" <?php echo e(old('jenis_zona') == 'ekspedisi' ? 'selected' : ''); ?>>Ekspedisi</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"><?php echo e(old('keterangan')); ?></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('<?php echo e(route('master-data.zona.index')); ?>')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/zona/create.blade.php ENDPATH**/ ?>