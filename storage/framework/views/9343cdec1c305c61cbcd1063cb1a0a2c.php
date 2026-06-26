<div class="sidebar" data-background-color="dark">
    <!-- Logo Header -->
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
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
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
                            <div class="collapse <?php echo e($link['is_active'] ? 'show' : ''); ?> sidebar-submenu" id="collapse_<?php echo e($index); ?>">
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
                                <p>
                                    <?php echo e($link['label']); ?>

                                    <?php if(!empty($link['badge'])): ?>
                                        <span class="badge bg-danger rounded-pill ms-1"><?php echo e($link['badge']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('1561425f-121e-4380-840d-92f6635b4b65')): $__env->markAsRenderedOnce('1561425f-121e-4380-840d-92f6635b4b65'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===================== ACCORDION DROPDOWN =====================
    var sidebarMenu = document.getElementById('sidebarAccordion');
    if (sidebarMenu) {
        var semuaSubmenu = sidebarMenu.querySelectorAll('.sidebar-submenu');

        semuaSubmenu.forEach(function (submenu) {
            // Saat salah satu submenu mulai terbuka, tutup semua submenu lain
            submenu.addEventListener('show.bs.collapse', function (event) {
                semuaSubmenu.forEach(function (lainnya) {
                    if (lainnya !== event.target) {
                        var instance = bootstrap.Collapse.getInstance(lainnya);
                        if (instance) {
                            instance.hide();
                        } else {
                            new bootstrap.Collapse(lainnya, { toggle: false }).hide();
                        }
                    }
                });
            });
        });
    }

    // ===================== INGAT STATE SIDEBAR MINIMIZE =====================
    var KUNCI_STORAGE = 'sigma_sidebar_minimize';
    var wrapper = document.querySelector('.wrapper');
    var tombolMinibutton = document.querySelector('.toggle-sidebar');

    if (wrapper) {
        // Terapkan state tersimpan segera saat halaman dimuat
        var tersimpanMinimize = localStorage.getItem(KUNCI_STORAGE) === '1';
        if (tersimpanMinimize) {
            wrapper.classList.add('sidebar_minimize');
            if (tombolMinibutton) {
                tombolMinibutton.classList.add('toggled');
                tombolMinibutton.innerHTML = '<i class="gg-more-vertical-alt"></i>';
            }
        }

        // Simpan state terbaru setiap kali tombol diklik
        if (tombolMinibutton) {
            tombolMinibutton.addEventListener('click', function () {
                setTimeout(function () {
                    var sedangMinimize = wrapper.classList.contains('sidebar_minimize');
                    localStorage.setItem(KUNCI_STORAGE, sedangMinimize ? '1' : '0');
                }, 50);
            });
        }
    }
});
</script>
<?php endif; ?>
<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/components/sidebar.blade.php ENDPATH**/ ?>