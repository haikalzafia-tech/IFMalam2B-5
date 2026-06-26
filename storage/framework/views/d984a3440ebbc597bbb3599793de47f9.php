
<form id="delete-form-<?php echo e($id); ?>" action="<?php echo e(route($route, $id)); ?>" method="POST" class="d-inline">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<button type="button" class="btn btn-danger btn-icon btn-round btn-xs"
    onclick="SigmaNotif.konfirmasiHapus('delete-form-<?php echo e($id); ?>')" title="Hapus">
    <i class="fas fa-trash"></i>
</button>
<?php /**PATH D:\laravel\ini baru\resources\views/components/confirm-delete.blade.php ENDPATH**/ ?>