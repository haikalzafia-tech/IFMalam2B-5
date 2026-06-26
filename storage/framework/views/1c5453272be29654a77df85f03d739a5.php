<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGMA - Daftar Akun Baru</title>
    <link rel="icon" href="<?php echo e(asset('template/assets/img/SIGMA.png')); ?>" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --primary: #0046b8;
            --accent: #3db5f1;
            --dark: #060b23;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Mengaktifkan skrol vertikal */
            overflow-y: auto;
            padding: 40px 20px;
        }

        /* Background Animasi */
        .bg-animate {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1;
            background: linear-gradient(125deg, #060b23 0%, #001a4d 50%, #050a1e 100%);
        }

        .blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(61, 181, 241, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: move 30s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(-20%, -20%); }
            to { transform: translate(30%, 30%); }
        }

        /* Card Styling 3D Glassmorphism */
        .auth-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-header { text-align: center; margin-bottom: 2rem; }
        .logo-header img { height: 60px; filter: drop-shadow(0 0 15px rgba(61, 181, 241, 0.4)); }

        .title { color: #fff; font-weight: 800; font-size: 1.5rem; margin-bottom: 0.5rem; text-align: center; }
        .subtitle { color: rgba(255, 255, 255, 0.5); font-size: 0.85rem; margin-bottom: 2rem; text-align: center; }

        /* Role Selector Styling */
        .role-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 1.5rem;
        }

        .role-option {
            flex: 1;
            position: relative;
        }

        .role-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .role-label {
            display: block;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 12px;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .role-option input:checked + .role-label {
            background: rgba(61, 181, 241, 0.1);
            border-color: var(--accent);
            color: var(--accent);
            box-shadow: 0 0 15px rgba(61, 181, 241, 0.2);
        }

        /* Form Inputs */
        .form-label { color: rgba(255, 255, 255, 0.8); font-weight: 600; font-size: 0.8rem; margin-bottom: 0.5rem; }

        .input-sigma {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 14px !important;
            color: #fff !important;
            padding: 12px 15px !important;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .input-sigma:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 15px rgba(61, 181, 241, 0.2) !important;
            outline: none;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            border-radius: 14px;
            padding: 14px;
            width: 100%;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
            transition: 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 70, 184, 0.4);
            filter: brightness(1.1);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .footer-text a { color: var(--accent); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

    <div class="bg-animate">
        <div class="blob"></div>
    </div>

    <div class="auth-card">
        <div class="logo-header">
            <img src="<?php echo e(asset('template/assets/img/SIGMA.png')); ?>" alt="SIGMA">
        </div>

        <h1 class="title">Identitas Baru</h1>
        <p class="subtitle">Daftarkan akun untuk mulai mengelola gudang.</p>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            <label class="form-label">Daftar Sebagai</label>
            <div class="role-selector">
                <div class="role-option">
                    <input type="radio" id="manager" name="role" value="manager" required>
                    <label for="manager" class="role-label">
                        <i class="fa-solid fa-user-tie mb-1 d-block"></i> Manajer
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control input-sigma <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Contoh: Haikal Mubaroq" required value="<?php echo e(old('name')); ?>">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control input-sigma <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="haikal@sigma.com" required value="<?php echo e(old('email')); ?>">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-control input-sigma" placeholder="••••••••" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi</label>
                    <input type="password" name="password_confirmation" class="form-control input-sigma" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register">
                Buat Akun <i class="fa-solid fa-user-plus ms-2"></i>
            </button>
        </form>

        <div class="footer-text">
            Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Masuk Sekarang</a>
            <br><br>
            <a href="/" style="opacity: 0.6;"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\laravel\IFMalam2B-5\resources\views/auth/register.blade.php ENDPATH**/ ?>