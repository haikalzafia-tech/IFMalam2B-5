<?php $__env->startSection('page_title', 'Detail Stok Opname'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">
            <?php echo e($stokOpname->nomor_opname); ?>

            <?php $statusColor = ['draft'=>'secondary','berlangsung'=>'warning','selesai'=>'success']; ?>
            <span class="badge bg-<?php echo e($statusColor[$stokOpname->status]); ?> ms-2"><?php echo e(ucfirst($stokOpname->status)); ?></span>
        </h4>
        <a href="<?php echo e(route('stok-opname.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-6 col-md-3"><small class="text-muted d-block">Gudang</small><span class="fw-semibold"><?php echo e($stokOpname->gudang->nama_gudang); ?></span></div>
            <div class="col-6 col-md-3"><small class="text-muted d-block">Tanggal</small><span class="fw-semibold"><?php echo e($stokOpname->tanggal_opname->format('d/m/Y')); ?></span></div>
            <div class="col-6 col-md-3"><small class="text-muted d-block">Petugas</small><span class="fw-semibold"><?php echo e($stokOpname->petugas); ?></span></div>
            <div class="col-6 col-md-3"><small class="text-muted d-block">Total Item</small><span class="fw-semibold"><?php echo e($stokOpname->items->count()); ?></span></div>
        </div>

        <?php if($stokOpname->status == 'berlangsung'): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-1"></i>
            Opname sedang berlangsung. Silakan isi stok fisik untuk setiap barang.
            <?php if(Auth::check() && Auth::user()->role !== 'admin'): ?>
                <br><small><strong>Catatan:</strong> Anda hanya dapat mengisi data. Penyesuaian stok akhir harus dilakukan oleh Admin.</small>
            <?php endif; ?>
        </div>

        <form action="<?php echo e(route('stok-opname.update', $stokOpname)); ?>" method="POST" id="form-opname">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>SKU</th>
                            <th>Barang</th>
                            <th>Rak</th>
                            <th class="text-center">Stok Sistem</th>
                            <th style="width:130px">Stok Fisik</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stokOpname->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($item->varianProduk->nomor_sku); ?></span></td>
                            <td class="fw-semibold"><?php echo e($item->varianProduk->produk->nama_produk); ?> - <?php echo e($item->varianProduk->nama_varian); ?></td>
                            <td><?php echo e($item->rak->kode_rak ?? '-'); ?></td>
                            <td class="text-center"><?php echo e($item->stok_sistem); ?></td>
                            <td>
                                <input type="hidden" name="items[<?php echo e($loop->index); ?>][id]" value="<?php echo e($item->id); ?>">
                                <input type="number" name="items[<?php echo e($loop->index); ?>][stok_fisik]" class="form-control form-control-sm"
                                    value="<?php echo e(old('items.'.$loop->index.'.stok_fisik', $item->stok_fisik)); ?>" min="0" required>
                            </td>
                            <td>
                                <input type="text" name="items[<?php echo e($loop->index); ?>][keterangan]" class="form-control form-control-sm"
                                    value="<?php echo e($item->keterangan); ?>" placeholder="Opsional">
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php if(Auth::check() && Auth::user()->role == 'admin'): ?>
                <button type="button" id="btn-selesai-opname" class="btn btn-success mt-2">
                    <i class="fas fa-check me-1"></i> Selesaikan Opname
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-save me-1"></i> Simpan Draft Data
                </button>
            <?php endif; ?>
        </form>

        <script>
        document.getElementById('btn-selesai-opname')?.addEventListener('click', function() {
            SigmaNotif.konfirmasi({
                judul: 'Selesaikan Opname?',
                teks: 'Stok sistem akan disesuaikan otomatis dengan stok fisik yang diinput.',
                icon: 'question',
            }, function() {
                document.getElementById('form-opname').submit();
            });
        });
        </script>

        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th>Rak</th>
                        <th class="text-center">Stok Sistem</th>
                        <th class="text-center">Stok Fisik</th>
                        <th class="text-center">Selisih</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $stokOpname->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($item->varianProduk->nomor_sku); ?></span></td>
                        <td class="fw-semibold"><?php echo e($item->varianProduk->produk->nama_produk); ?> - <?php echo e($item->varianProduk->nama_varian); ?></td>
                        <td><?php echo e($item->rak->kode_rak ?? '-'); ?></td>
                        <td class="text-center"><?php echo e($item->stok_sistem); ?></td>
                        <td class="text-center"><?php echo e($item->stok_fisik); ?></td>
                        <td class="text-center">
                            <?php $selisih = $item->stok_fisik - $item->stok_sistem; ?>
                            <span class="badge bg-<?php echo e($selisih == 0 ? 'success' : ($selisih > 0 ? 'info' : 'danger')); ?>">
                                <?php echo e($selisih > 0 ? '+' : ''); ?><?php echo e($selisih); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->keterangan ?? '-'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/stok-opname/show.blade.php ENDPATH**/ ?>