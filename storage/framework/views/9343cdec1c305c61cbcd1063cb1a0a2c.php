<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="/home" class="logo d-flex align-items-center">
                <img src="<?php echo e(asset('template/assets/img/SIGMA.png')); ?>" alt="SIGMA" class="navbar-brand" height="40" />
                <span class="text-white fw-bold ms-2" style="font-size: 18px; letter-spacing: 1px;">SIGMA</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary" id="sidebarAccordion">
                <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($link['is_dropdown']): ?>
                        <li class="nav-item <?php echo e($link['is_active'] ? 'active' : ''); ?>">
                            <a data-bs-toggle="collapse" href="#collapse_<?php echo e($index); ?>" class="<?php echo e($link['is_active'] ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($link['is_active'] ? 'true' : 'false'); ?>">
                                <i class="<?php echo e($link['icon']); ?>"></i>
                                <p><?php echo e($link['label']); ?></p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse <?php echo e($link['is_active'] ? 'show' : ''); ?> sidebar-submenu" id="collapse_<?php echo e($index); ?>" data-bs-parent="#sidebarAccordion">
                                <ul class="nav nav-collapse">
                                    <?php $__currentLoopData = $link['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e(route($item['route'])); ?>">
                                                <span class="sub-item"><?php echo e($item['label']); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item <?php echo e($link['is_active'] ? 'active' : ''); ?>">
                            <a href="<?php echo e(route($link['route'])); ?>">
                                <i class="<?php echo e($link['icon']); ?>"></i>
                                <p><?php echo e($link['label']); ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Memastikan setiap klik pada menu dropdown akan menutup yang lain
    var dropdownLinks = document.querySelectorAll('#sidebarAccordion [data-bs-toggle="collapse"]');

    dropdownLinks.forEach(function(el) {
        el.addEventListener('click', function() {
            var targetId = this.getAttribute('href');
            var allCollapses = document.querySelectorAll('.sidebar-submenu');

            allCollapses.forEach(function(col) {
                if ('#' + col.id !== targetId && col.classList.contains('show')) {
                    var collapseInstance = bootstrap.Collapse.getInstance(col);
                    if (collapseInstance) {
                        collapseInstance.hide();
                    }
                }
            });
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/components/sidebar.blade.php ENDPATH**/ ?>