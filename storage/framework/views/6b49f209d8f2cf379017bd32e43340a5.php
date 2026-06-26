<div>
    
    <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>

        
        <button type="button" class="btn btn-round <?php echo e($id ? 'btn-primary btn-icon' : 'btn-dark'); ?>"
            data-bs-toggle="modal"
            data-bs-target="#formProduk<?php echo e($id ?? ''); ?>">
            <?php if($id): ?>
                <i class="fas fa-edit"></i>
            <?php else: ?>
                <i class="fas fa-plus me-1"></i>
                <span>Barang Baru</span>
            <?php endif; ?>
        </button>

        
        <div class="modal fade" id="formProduk<?php echo e($id ?? ''); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="formProdukLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo e($action); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php if($id): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>

                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formProdukLabel">
                                <?php echo e($id ? 'Edit Barang' : 'Form Tambah Barang'); ?>

                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-start">
                            
                            <div class="form-group mb-3">
                                <label for="kategori_produk_id" class="form-label fw-bold">Kategori Barang</label>
                                <select name="kategori_produk_id" id="kategori_produk_id" class="form-control">
                                    <option value="">Pilih Kategori</option>
                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"
                                            <?php echo e(old('kategori_produk_id', $kategori_produk_id ?? '') == $item->id ? 'selected' : ''); ?>>
                                            <?php echo e($item->nama_kategori); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="form-group mb-3">
                                <label for="nama_produk" class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                                    value="<?php echo e(old('nama_produk', $nama_produk ?? '')); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="merek" class="form-label fw-bold">Merek</label>
                                        <input type="text" name="merek" id="merek" class="form-control"
                                            value="<?php echo e(old('merek', $merek ?? '')); ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="satuan" class="form-label fw-bold">Satuan</label>
                                        <input type="text" name="satuan" id="satuan" class="form-control"
                                            placeholder="pcs, kg, karton, dll" value="<?php echo e(old('satuan', $satuan ?? '')); ?>" required>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="form-group mb-3">
                                <label for="stok_minimum" class="form-label fw-bold">Stok Minimum</label>
                                <input type="number" name="stok_minimum" id="stok_minimum" class="form-control"
                                    placeholder="Batas minimum untuk alert stok menipis"
                                    value="<?php echo e(old('stok_minimum', $stok_minimum ?? 0)); ?>" required>
                            </div>

                            
                            <div class="form-group mb-3">
                                <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi</label>
                                <textarea name="deskripsi_produk" id="deskripsi_produk" cols="30" rows="4"
                                    class="form-control"><?php echo e(old('deskripsi_produk', $deskripsi_produk ?? '')); ?></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <?php if($id): ?>
            <?php if (isset($component)) { $__componentOriginal73f36b44041cfc386eb521d3e76b4de7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73f36b44041cfc386eb521d3e76b4de7 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmDelete::resolve(['route' => 'master-data.produk.destroy','id' => $id] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirm-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmDelete::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal73f36b44041cfc386eb521d3e76b4de7)): ?>
<?php $attributes = $__attributesOriginal73f36b44041cfc386eb521d3e76b4de7; ?>
<?php unset($__attributesOriginal73f36b44041cfc386eb521d3e76b4de7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal73f36b44041cfc386eb521d3e76b4de7)): ?>
<?php $component = $__componentOriginal73f36b44041cfc386eb521d3e76b4de7; ?>
<?php unset($__componentOriginal73f36b44041cfc386eb521d3e76b4de7); ?>
<?php endif; ?>
        <?php endif; ?>

    <?php else: ?>
        <span class="badge bg-info text-white"><i class="fas fa-lock me-1"></i> Khusus (Admin)</span>
    <?php endif; ?>
</div>
<?php /**PATH D:\laravel\ini baru\resources\views/components/produk/form-produk.blade.php ENDPATH**/ ?>