<div>
    
    <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
        <div class="d-flex align-items-center justify-content-center gap-2">

            <!-- TOMBOL EDIT / TAMBAH -->
            <button type="button" class="btn btn-round <?php echo e($id ? 'btn-primary btn-icon' : 'btn-dark'); ?>"
                data-bs-toggle="modal"
                data-bs-target="#formKategori<?php echo e($id ?? ''); ?>">
                <?php if($id): ?>
                    <i class="fas fa-edit"></i>
                <?php else: ?>
                    <i class="fas fa-plus me-1"></i>
                    <span>Buat Baru</span>
                <?php endif; ?>
            </button>

            <!-- TOMBOL HAPUS (Hanya muncul jika di dalam tabel/ada ID) -->
            <?php if($id): ?>
                <form action="<?php echo e(route('master-data.kategori-produk.destroy', $id)); ?>" method="POST" id="delete-form-<?php echo e($id); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" class="btn btn-danger btn-icon btn-round" onclick="confirmDelete('<?php echo e($id); ?>')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="modal fade" id="formKategori<?php echo e($id ?? ''); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="formKategori" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo e($action ?? route('master-data.kategori-produk.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php if($id): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formKategoriLabel">
                                <?php echo e($id ? 'Edit Kategori Barang' : 'Tambah Kategori Barang'); ?>

                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <div class="form-group mb-3">
                                <label for="nama_kategori" class="form-label fw-bold">Nama Kategori</label>
                                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                                    value="<?php echo e(old('nama_kategori', $nama_kategori ?? '')); ?>" placeholder="Masukkan nama kategori" required>
                                <?php $__errorArgs = ['nama_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"
                                    placeholder="Deskripsi singkat kategori (opsional)"><?php echo e(old('deskripsi', $deskripsi ?? '')); ?></textarea>
                                <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

   <?php else: ?>
        <span class="badge bg-info text-white"><i class="fas fa-lock me-1"></i> Khusus (Admin)</span>
    <?php endif; ?>
</div>

<?php $__env->startPush('script'); ?>
<script>
    function confirmDelete(id) {
        swal({
            title: "Hapus Data?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Batal",
                    className: "btn btn-secondary",
                },
                confirm: {
                    text: "Ya, Hapus!",
                    className: "btn btn-danger",
                },
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\laravel\ini baru\resources\views/components/kategori-produk/form-kategori-produk.blade.php ENDPATH**/ ?>