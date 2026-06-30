<div>
    <input type="text" name="<?php echo e($term); ?>" id="<?php echo e($term); ?>" class="form-control" placeholder="<?php echo e($placeholder); ?>"
        value="<?php echo e(request($term)); ?>"
        onkeydown="if(event.key === 'Enter'){window.location.href = '?<?php echo e($term); ?>=' + this.value}">
</div><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/components/filter-by-field.blade.php ENDPATH**/ ?>