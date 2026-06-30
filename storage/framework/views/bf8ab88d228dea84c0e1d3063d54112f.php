<div>
    <select name="perPage" id="perPage" class="form-control" onchange="window.location.href = '?perPage=' + this.value"
        style="width: 100px">
        <option value="">Pilih Baris</option>
        <?php $__currentLoopData = $perPageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/components/per-page-option.blade.php ENDPATH**/ ?>