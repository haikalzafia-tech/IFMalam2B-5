<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Menangani error Undefined variable $pageTitle --}}
     <link rel="icon" href="{{ asset('template') }}/assets/img/SIGMA.png" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Fonts and icons -->
    <script src="{{ asset('template') }}/assets/js/plugin/webfont/webfont.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <title>{{ $pageTitle ?? 'SIGMA' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --sigma-blue-dark: #0046b8;
            --sigma-blue-light: #3db5f1;
            --sigma-bg: #f8f9fa;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background: var(--sigma-bg);
            color: #222;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- Navbar --- */
        .navbar-sigma {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0, 70, 184, 0.1);
            z-index: 1000;
        }

        /* --- Hero Section --- */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: radial-gradient(circle at top right, rgba(61, 181, 241, 0.12) 0%, transparent 60%),
                        radial-gradient(circle at bottom left, rgba(0, 70, 184, 0.08) 0%, transparent 60%);
            position: relative;
        }

        #canvas-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 50%;
            height: 100%;
            z-index: 1;
            mask-image: linear-gradient(to right, transparent 0%, black 30%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 30%);
        }

        .hero-content { position: relative; z-index: 2; }

        /* --- Efek 3D Neumorphism --- */
        .feature-card {
            background: #ffffff;
            border-radius: 30px;
            padding: 40px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-20px) rotateX(10deg) rotateY(-5deg);
            box-shadow: 30px 30px 80px rgba(0, 70, 184, 0.15);
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
        }

        .icon-3d-wrapper {
            width: 90px;
            height: 90px;
            background: linear-gradient(145deg, #e6e6e6, #ffffff);
            box-shadow: 5px 5px 15px #d1d1d1, -5px -5px 15px #ffffff;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px auto;
            transition: 0.3s;
        }

        .feature-card:hover .icon-3d-wrapper {
            background: var(--sigma-blue-dark);
            color: white !important;
        }

        .btn-sigma {
            background: linear-gradient(135deg, var(--sigma-blue-dark), var(--sigma-blue-light));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(0, 70, 184, 0.2);
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .text-gradient {
            background: linear-gradient(to right, var(--sigma-blue-dark), var(--sigma-blue-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @media (max-width: 991px) {
            #canvas-container { position: relative; width: 100%; height: 400px; mask-image: none; }
            .hero-section { text-align: center; padding-top: 100px; }
            .d-flex.gap-3 { justify-content: center; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light navbar-sigma fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold fs-3" href="landing">
                {{-- Menggunakan path yang sesuai dengan folder assets anda --}}
                <img src="{{ asset('template/assets/img/SIGMA.png') }}" alt="Logo" height="40" class="me-2">
                <span class="text-gradient">SIGMA</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center">
                    {{-- Menangani error profil null dengan pengecekan auth --}}
                    @auth
                        <span class="fw-bold me-3">Hi, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="btn btn-link text-dark text-decoration-none fw-bold">Logout</a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-link text-dark text-decoration-none fw-bold me-3">Login</a>
                        <a href="#" class="btn btn-sigma btn-sm">Get Started</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section">
        <div id="canvas-container"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="text-primary fw-bold text-uppercase mb-3" style="letter-spacing: 3px;">Warehouse Management</h6>
                    <h1 class="display-3 fw-bold mb-4">Sistem <span class="text-gradient">Gudang</span> Manajemen</h1>
                    <p class="lead text-secondary mb-5 fs-4">Optimalkan inventaris dan pantau stok secara real-time dengan teknologi visualisasi cerdas.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-sigma btn-lg">Mulai Sekarang</a>
                        {{-- Navigasi otomatis ke ID #features --}}
                        <a href="#features" class="btn btn-outline-dark btn-lg rounded-pill px-4">Lihat Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section dengan ID untuk navigasi URL --}}
    <section id="features" class="py-5 bg-white" style="perspective: 1000px;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5 mb-3">Keunggulan <span class="text-gradient">SIGMA</span></h2>
                <div class="mx-auto" style="width: 80px; height: 5px; background: var(--sigma-blue-dark); border-radius: 10px;"></div>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-3d-wrapper text-primary">
                            <i class="fa-solid fa-box-open fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Stok Real-time</h4>
                        <p class="text-secondary">Pantau pergerakan barang setiap detik tanpa jeda dengan sistem sinkronisasi otomatis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-3d-wrapper text-primary">
                            <i class="fa-solid fa-chart-pie fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Laporan Akurat</h4>
                        <p class="text-secondary">Analisis data stok yang mudah dipahami untuk pengambilan keputusan cepat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-3d-wrapper text-primary">
                            <i class="fa-solid fa-shield-halved fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Keamanan Data</h4>
                        <p class="text-secondary">Sistem enkripsi tingkat tinggi untuk menjaga seluruh data inventaris perusahaan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 text-center text-muted border-top bg-light">
        <p>© 2026 <strong>SIGMA</strong> - Teknik Informatika Polibatam.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        // --- Inisialisasi Three.js ---
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });

        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);

        const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
        scene.add(ambientLight);
        const mainLight = new THREE.DirectionalLight(0xffffff, 1.2);
        mainLight.position.set(5, 10, 7);
        scene.add(mainLight);

        const group = new THREE.Group();
        const textureLoader = new THREE.TextureLoader();
        const logoTexture = textureLoader.load("{{ asset('template/assets/img/SIGMA.png') }}");

        const logoGeo = new THREE.PlaneGeometry(5.5, 5.5);
        const logoMat = new THREE.MeshBasicMaterial({ map: logoTexture, transparent: true, side: THREE.DoubleSide });
        const logoPlane = new THREE.Mesh(logoGeo, logoMat);
        group.add(logoPlane);

        const ringShape = new THREE.Shape();
        ringShape.absarc(0, 0, 3.8, 0, Math.PI * 2, false);
        const holePath = new THREE.Path();
        holePath.absarc(0, 0, 3.7, 0, Math.PI * 2, true);
        ringShape.holes.push(holePath);

        const extrudeSettings = { depth: 0.2, bevelEnabled: true, bevelThickness: 0.05, bevelSize: 0.05, bevelSegments: 5 };
        const ringGeo = new THREE.ExtrudeGeometry(ringShape, extrudeSettings);
        const ringMat = new THREE.MeshPhongMaterial({ color: 0x3db5f1, shininess: 100, transparent: true, opacity: 0.6 });
        const ring = new THREE.Mesh(ringGeo, ringMat);
        ring.position.z = -0.1;
        group.add(ring);

        scene.add(group);
        camera.position.z = 11;

        function animate() {
            requestAnimationFrame(animate);
            group.rotation.y += 0.012;
            group.position.y = Math.sin(Date.now() * 0.0015) * 0.25;
            renderer.render(scene, camera);
        }
        animate();

        // --- Logika Dynamic Title Berdasarkan Scroll ---
        window.addEventListener('scroll', () => {
            const featuresSection = document.getElementById('features');
            const rect = featuresSection.getBoundingClientRect();

            if (rect.top <= 200 && rect.bottom >= 200) {
                document.title = "SIGMA - Keunggulan Layanan";
                // Menambah hash ke URL tanpa reload jika diinginkan
                if(window.location.hash !== "#features") {
                    history.replaceState(null, null, "#features");
                }
            } else {
                document.title = "{{ $pageTitle ?? 'SIGMA - Sistem Gudang Manajemen' }}";
                if(window.location.hash !== "") {
                    history.replaceState(null, null, " ");
                }
            }
        });

        window.addEventListener('resize', () => {
            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
