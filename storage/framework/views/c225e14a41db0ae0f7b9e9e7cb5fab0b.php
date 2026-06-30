<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo e(env('APP_NAME')); ?></title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo e(asset('template')); ?>/assets/img/SIGMA.png" type="image/x-icon" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <!-- Fonts and icons -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/webfont/webfont.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["<?php echo e(asset('template')); ?>/assets/css/fonts.min.css"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo e(asset('template')); ?>/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('template')); ?>/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('template')); ?>/assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('template')); ?>/assets/css/sigma-design-system.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo e(asset('template')); ?>/assets/css/demo.css" />

    <!-- Sistem Notifikasi 3D Terpusat -->
    <link rel="stylesheet" href="<?php echo e(asset('template')); ?>/assets/css/sigma-notif.css" />
</head>

<body>
    <?php echo $__env->make('sweetalert::alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php if (isset($component)) { $__componentOriginald31f0a1d6e85408eecaaa9471b609820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald31f0a1d6e85408eecaaa9471b609820 = $attributes; } ?>
<?php $component = App\View\Components\Sidebar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Sidebar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald31f0a1d6e85408eecaaa9471b609820)): ?>
<?php $attributes = $__attributesOriginald31f0a1d6e85408eecaaa9471b609820; ?>
<?php unset($__attributesOriginald31f0a1d6e85408eecaaa9471b609820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald31f0a1d6e85408eecaaa9471b609820)): ?>
<?php $component = $__componentOriginald31f0a1d6e85408eecaaa9471b609820; ?>
<?php unset($__componentOriginald31f0a1d6e85408eecaaa9471b609820); ?>
<?php endif; ?>
        <!-- Menggunakan komponen sidebar.blade.php (resources/views/components/sidebar.blade.php)(sudah ada di dalam
            folder components) -->

        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="<?php echo e(asset('template')); ?>/assets/img/SIGMA.png" alt="navbar brand"
                                class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                    <img src="<?php echo e(auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('template/assets/img/profile.jpg')); ?>"
                                    alt="..." class="avatar-img rounded-circle">
                                </div>
                                <span class="profile-username">
                                    <span class="op-7">Hai,</span>
                                    <span class="fw-bold"><?php echo e(auth()->user()->name); ?></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <img src="<?php echo e(Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('template/assets/img/profile.jpg')); ?>"
                                                alt="image profile" class="avatar-img rounded">
                                            </div>
                                            <div class="u-text">
                                                <h4><?php echo e(Auth::user()->name); ?></h4>
                                                <p class="text-muted"><?php echo e(Auth::user()->email); ?></p>
                                                <a href="profile" class="btn btn-xs btn-secondary btn-sm">Lihat
                                                    Profil</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <div>
                                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                    <?php echo e(__('Keluar')); ?>

                                                </a>

                                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                                    class="d-none">
                                                    <?php echo csrf_field(); ?>
                                                </form>
                                            </div>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title"><?php echo $__env->yieldContent('page_title', 'Sistem Manajemen Gudang'); ?></h4>
                    </div>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            <footer class="py-5 text-center text-muted border-top bg-light">
        <p>© 2026 <strong>SIGMA</strong> - Teknik Informatika Polibatam.</p>
    </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo e(asset('template')); ?>/assets/js/core/popper.min.js"></script>
    <script src="<?php echo e(asset('template')); ?>/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js">
    </script>

    <!-- Chart JS -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js">
    </script>

    <!-- Chart Circle -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js">
    </script>

    <!-- jQuery Vector Maps -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/kaiadmin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <!-- Sistem Notifikasi 3D Terpusat -->
    <script src="<?php echo e(asset('template')); ?>/assets/js/sigma-notif.js"></script>
    <script>
        // Kirim pesan flash dari Laravel session ke JS, untuk ditampilkan sebagai toast
        window.SIGMA_FLASH = {
            success: <?php echo json_encode(session('success'), 15, 512) ?>,
            error: <?php echo json_encode(session('error'), 15, 512) ?>,
        };
    </script>

    <?php echo $__env->yieldPushContent('script'); ?>


</body>

</html>
<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/layouts/kai.blade.php ENDPATH**/ ?>