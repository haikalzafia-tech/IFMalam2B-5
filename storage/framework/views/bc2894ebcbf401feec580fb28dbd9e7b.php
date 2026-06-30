<?php $__env->startSection('page_title', $pageTitle); ?>
<?php $__env->startSection('content'); ?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-box-open" style="color: var(--sigma-navy-500)"></i>
            <h4 class="card-title mb-0"><?php echo e($produk->nama_produk); ?></h4>
        </div>
        <a href="<?php echo e(route('master-data.produk.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted d-block">Kategori</small>
                <span class="fw-semibold"><?php echo e($produk->kategoriProduk->nama_kategori ?? 'Tanpa Kategori'); ?></span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Kode Produk</small>
                <span class="fw-semibold"><?php echo e($produk->kode_produk); ?></span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Satuan</small>
                <span class="fw-semibold"><?php echo e($produk->satuan); ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Merek</small>
                <span class="fw-semibold"><?php echo e($produk->merek ?: '-'); ?></span>
            </div>
            <div class="col-12">
                <hr class="my-2" style="border-color: var(--sigma-border)">
                <small class="text-muted d-block mb-1">Deskripsi</small>
                <p class="mb-0"><?php echo e($produk->deskripsi_produk ?: '-'); ?></p>
            </div>
            <div class="col-12">
                <hr class="my-2" style="border-color: var(--sigma-border)">
                <?php $totalStok = $produk->varianProduks->sum('stok_varian'); ?>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span class="badge bg-<?php echo e($totalStok < $produk->stok_minimum ? 'danger' : 'success'); ?>" style="font-size: 13px; padding: 8px 16px;">
                        <i class="fas fa-cubes me-1"></i> Total Stok: <?php echo e(number_format($totalStok)); ?> <?php echo e($produk->satuan); ?>

                    </span>
                    <span class="text-muted small">Batas minimum: <?php echo e(number_format($produk->stok_minimum)); ?> <?php echo e($produk->satuan); ?></span>
                    <?php if($totalStok < $produk->stok_minimum): ?>
                    <span class="badge bg-warning"><i class="fas fa-exclamation-triangle me-1"></i> Di bawah minimum</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Daftar Varian</h4>
        <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormVarian" id="btnTambahVarian">
                <i class="fas fa-plus me-1"></i> Tambah Varian
            </button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php $__empty_1 = true; $__currentLoopData = $produk->varianProduks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <?php if (isset($component)) { $__componentOriginal9daa4297d6a4bbb911c00792270b5a0d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9daa4297d6a4bbb911c00792270b5a0d = $attributes; } ?>
<?php $component = App\View\Components\Produk\CardVarian::resolve(['varian' => $item] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('produk.card-varian'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Produk\CardVarian::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9daa4297d6a4bbb911c00792270b5a0d)): ?>
<?php $attributes = $__attributesOriginal9daa4297d6a4bbb911c00792270b5a0d; ?>
<?php unset($__attributesOriginal9daa4297d6a4bbb911c00792270b5a0d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9daa4297d6a4bbb911c00792270b5a0d)): ?>
<?php $component = $__componentOriginal9daa4297d6a4bbb911c00792270b5a0d; ?>
<?php unset($__componentOriginal9daa4297d6a4bbb911c00792270b5a0d); ?>
<?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-layer-group fa-2x text-muted mb-2 d-block opacity-50"></i>
                    <p class="text-muted mb-0">Belum ada varian barang.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
    <?php if (isset($component)) { $__componentOriginal570018561b2d43337c6927949153b88d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal570018561b2d43337c6927949153b88d = $attributes; } ?>
<?php $component = App\View\Components\Produk\FormVarian::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('produk.form-varian'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Produk\FormVarian::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['raks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($raks),'produk_id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($produk->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal570018561b2d43337c6927949153b88d)): ?>
<?php $attributes = $__attributesOriginal570018561b2d43337c6927949153b88d; ?>
<?php unset($__attributesOriginal570018561b2d43337c6927949153b88d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal570018561b2d43337c6927949153b88d)): ?>
<?php $component = $__componentOriginal570018561b2d43337c6927949153b88d; ?>
<?php unset($__componentOriginal570018561b2d43337c6927949153b88d); ?>
<?php endif; ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
$(document).ready(function() {
    let modalEl = $('#modalFormVarian');
    if (modalEl.length > 0) {
        let modal = new bootstrap.Modal(modalEl[0]);
        let $form = $('#modalFormVarian form');
        let defaultAction = $form.attr('action');

        $("#btnTambahVarian").on('click', function() {
            $form[0].reset();
            $form.attr('action', defaultAction);
            $form.find('input[name="_method"]').remove();
            $form.find('small.text-danger').text('');
            $('#modalFormVarianLabel').text('Tambah Varian Baru');
            modal.show();
        });

        $(document).on('click', ".btnEditVarian", function() {
            let namaVarian = $(this).data('nama-varian');
            let rakId = $(this).data('rak-id');
            let stokVarian = $(this).data('stok-varian');
            let berat = $(this).data('berat');
            let dimensi = $(this).data('dimensi');
            let action = $(this).data('action');

            $form[0].reset();
            $form.attr('action', action);

            if($form.find('input[name="_method"]').length === 0){
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.find('select[name="rak_id"]').val(rakId);
            $form.find('input[name="nama_varian"]').val(namaVarian);
            $form.find('input[name="stok_varian"]').val(stokVarian);
            $form.find('input[name="berat"]').val(berat);
            $form.find('input[name="dimensi"]').val(dimensi);
            $form.find('small.text-danger').text('');
            $('#modalFormVarianLabel').text('Edit Varian');
            modal.show();
        });

        $form.submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    SigmaNotif.sukses(response.message);
                    setTimeout(() => location.reload(), 1200);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    $form.find('small.text-danger').text('');
                    $.each(errors, function(key, val) {
                        $form.find('[name="' + key + '"]').next('small.text-danger').text(val[0]);
                    })
                }
            });
        });
    }

    $(document).on('click', ".formDeleteVarian button", function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        SigmaNotif.konfirmasi({
            judul: 'Hapus Varian?',
            teks: 'Data ini tidak bisa dikembalikan!',
            icon: 'warning',
        }, function() {
            form.submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/produk/show.blade.php ENDPATH**/ ?>