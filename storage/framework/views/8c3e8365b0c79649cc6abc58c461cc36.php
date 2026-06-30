
<?php
    $modalId = 'modalExport' . ($id ?? '');
?>

<div class="modal fade" id="<?php echo e($modalId); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route($route)); ?>" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-excel me-2" style="color: var(--sigma-success)"></i><?php echo e($judul); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Kosongkan kedua tanggal jika ingin mengexport seluruh data tanpa batasan periode.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download me-1"></i> Download Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/components/export-modal.blade.php ENDPATH**/ ?>