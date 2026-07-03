<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGMA - Masuk Aman</title>
    <link rel="icon" href="{{ asset('template/assets/img/SIGMA.png') }}" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --primary: #0046b8;
            --accent: #3db5f1;
            --dark: #060b23;
            --danger: #ff4b4b;
            --success: #00b09b;
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
            overflow-y: auto;
            padding: 50px 20px;
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
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 70, 184, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: move 25s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(-10%, -10%); }
            to { transform: translate(20%, 20%); }
        }

        /* Card Container 3D Glassmorphism */
        .auth-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 3rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
            transition: transform 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Styling Alert Error & Success */
        .alert-sigma {
            background: rgba(255, 75, 75, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 75, 75, 0.3);
            border-radius: 16px;
            color: #ff8a8a;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            animation: shakeX 0.5s;
        }

        .alert-sigma-success {
            background: rgba(0, 176, 155, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 176, 155, 0.3);
            border-radius: 16px;
            color: #7effc0;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            text-align: center;
        }

        @keyframes shakeX {
            from, to { transform: translate3d(0, 0, 0); }
            10%, 30%, 50%, 70%, 90% { transform: translate3d(-10px, 0, 0); }
            20%, 40%, 60%, 80% { transform: translate3d(10px, 0, 0); }
        }

        .logo-wrapper {
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo-wrapper img {
            height: 80px;
            filter: drop-shadow(0 0 20px rgba(61, 181, 241, 0.4));
        }

        .title {
            color: #fff;
            font-weight: 800;
            font-size: 1.75rem;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }

        /* Input Styling */
        .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.6rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
            opacity: 0.7;
            z-index: 10;
        }

        .form-control-sigma {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 14px 14px 14px 50px;
            color: #fff !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-sigma:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent);
            box-shadow: 0 0 20px rgba(61, 181, 241, 0.2);
            outline: none;
        }

        /* Button Styling */
        .btn-sigma-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border: none;
            border-radius: 16px;
            padding: 16px;
            color: white;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-sigma-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 70, 184, 0.4);
            filter: brightness(1.1);
        }

        .footer-links {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .auth-card { padding: 2rem; }
        }
    </style>
</head>
<body>

    <div class="bg-animate">
        <div class="blob"></div>
        <div class="blob" style="bottom: -100px; right: -100px; animation-delay: -5s;"></div>
    </div>

    <div class="auth-card">
        <div class="logo-wrapper">
            <img src="{{ asset('template/assets/img/SIGMA.png') }}" alt="SIGMA">
        </div>

        <div class="text-center">
            <h1 class="title">Selamat Datang</h1>
            <p class="subtitle">Silakan masuk untuk mengakses dashboard SIGMA.</p>
        </div>

        <!-- NOTIFIKASI ERROR (BAHASA INDONESIA) -->
        @if ($errors->any())
            <div class="alert-sigma">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-exclamation me-3 fs-4"></i>
                    <div>
                        <ul class="mb-0 list-unstyled">
                            @foreach ($errors->all() as $error)
                                @php
                                    $msg = $error;
                                    if(str_contains($error, 'credentials') || str_contains($error, 'failed')) {
                                        $msg = 'Email atau kata sandi salah.';
                                    } elseif(str_contains($error, 'password')) {
                                        $msg = 'Kata sandi tidak valid.';
                                    } elseif(str_contains($error, 'email')) {
                                        $msg = 'Format email tidak sesuai.';
                                    } elseif(str_contains($error, 'throttle')) {
                                        $msg = 'Terlalu banyak percobaan masuk. Coba lagi nanti.';
                                    }
                                @endphp
                                <li>{{ $msg }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- NOTIFIKASI STATUS -->
        @if (session('status'))
            <div class="alert-sigma-success">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <div class="input-group-custom">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" class="form-control form-control-sigma" placeholder="user@polibatam.ac.id" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <div class="input-group-custom">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" class="form-control form-control-sigma" placeholder="••••••••" required>
                </div>
            </div>

            {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label small text-white-50" for="remember">
                        Ingat saya
                    </label>
                </div>
            </div> --}}

            <button type="submit" class="btn btn-sigma-primary">
                Masuk Sekarang <i class="fa-solid fa-right-to-bracket ms-2"></i>
            </button>
        </form>

        <div class="footer-links">
            <p class="text-white-50">Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <a href="/" class="text-white-50"><i class="fa-solid fa-house me-1"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
