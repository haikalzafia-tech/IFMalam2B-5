<?php $__env->startSection('page_title', 'Tambah Supplier'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Supplier</h4>
                <a href="<?php echo e(route('master-data.supplier.index')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
                <?php endif; ?>

                <form action="<?php echo e(route('master-data.supplier.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-building me-1"></i> Informasi Perusahaan</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" class="form-control" value="<?php echo e(old('nama_supplier')); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Supplier <span class="text-danger">*</span></label>
                            <select name="jenis_supplier" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="produsen" <?php echo e(old('jenis_supplier') == 'produsen' ? 'selected' : ''); ?>>Produsen</option>
                                <option value="distributor" <?php echo e(old('jenis_supplier') == 'distributor' ? 'selected' : ''); ?>>Distributor</option>
                                <option value="agen" <?php echo e(old('jenis_supplier') == 'agen' ? 'selected' : ''); ?>>Agen</option>
                                <option value="retailer" <?php echo e(old('jenis_supplier') == 'retailer' ? 'selected' : ''); ?>>Retailer</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required><?php echo e(old('alamat')); ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control" value="<?php echo e(old('kota')); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control" value="<?php echo e(old('provinsi')); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" value="<?php echo e(old('kode_pos')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NPWP</label>
                            <input type="text" name="npwp" class="form-control" value="<?php echo e(old('npwp')); ?>" placeholder="Opsional">
                        </div>
                    </div>

                    <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-user me-1"></i> Penanggung Jawab (PIC)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama PIC <span class="text-danger">*</span></label>
                            <input type="text" name="pic_nama" class="form-control" value="<?php echo e(old('pic_nama')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan PIC</label>
                            <input type="text" name="pic_jabatan" class="form-control" value="<?php echo e(old('pic_jabatan')); ?>" placeholder="Contoh: Sales Manager">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control" value="<?php echo e(old('telepon')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"><?php echo e(old('keterangan')); ?></textarea>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('<?php echo e(route('master-data.supplier.index')); ?>')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/supplier/create.blade.php ENDPATH**/ ?>