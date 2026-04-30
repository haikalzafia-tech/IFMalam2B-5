<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGMA - Secure Login</title>
    <link rel="icon" href="{{ asset('template/assets/img/SIGMA.png') }}" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --primary: #0046b8;
            --accent: #3db5f1;
            --dark: #060b23;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Background Animasi Berjalan */
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

        /* Card Container */
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
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
        }

        .form-control-sigma {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 14px 14px 14px 50px;
            color: #fff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-sigma:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent);
            box-shadow: 0 0 20px rgba(61, 181, 241, 0.2);
            color: #fff;
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
            filter: brightness(1.2);
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
            <h1 class="title">Welcome Back</h1>
            <p class="subtitle">Please enter your credentials to access SIGMA.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group-custom">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" class="form-control form-control-sigma" placeholder="name@company.com" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" class="form-control form-control-sigma" placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label small text-white-50" for="remember">
                        Remember me
                    </label>
                </div>
                <a href="#" class="small text-accent text-decoration-none">Forgot?</a>
            </div>

            <button type="submit" class="btn btn-sigma-primary">
                Sign In <i class="fa-solid fa-right-to-bracket ms-2"></i>
            </button>
        </form>

        <div class="footer-links">
            <p class="text-white-50">Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
            <a href="/" class="text-white-50"><i class="fa-solid fa-house me-1"></i> Return to Landing</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
