<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('template/assets/img/SIGMA.png') }}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $pageTitle ?? 'SIGMA - Sistem Manajemen Gudang' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sigma-blue-primary: #0056e0;
            --sigma-blue-light: #3db5f1;
            --sigma-dark-bg: #060b23;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--sigma-dark-bg);
            color: #ffffff;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- Navbar Ultra Glassmorphism --- */
        .navbar-sigma {
            background: rgba(6, 11, 35, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1.2rem 0;
        }

        .text-gradient {
            background: linear-gradient(135deg, #fff 30%, var(--sigma-blue-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        /* --- Hero Section --- */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            background:
                radial-gradient(circle at 10% 20%, rgba(0, 86, 224, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(61, 181, 241, 0.1) 0%, transparent 40%);
        }

        #canvas-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 50%;
            height: 100%;
            z-index: 1;
            mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
        }

        .hero-content { position: relative; z-index: 2; }

        /* --- Kartu Fitur & Profil 3D --- */
        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 35px;
            padding: 45px 30px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: var(--sigma-blue-light);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(61, 181, 241, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        .icon-3d-box {
            width: 85px;
            height: 85px;
            background: linear-gradient(135deg, var(--sigma-blue-primary), var(--sigma-blue-light));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            transform: rotateX(15deg) rotateY(-15deg);
            transition: 0.3s;
        }

        .feature-card:hover .icon-3d-box {
            transform: rotateX(0deg) rotateY(0deg) scale(1.1);
            box-shadow: 0 0 25px var(--sigma-blue-light);
        }

        /* --- Creator Section Styling --- */
        .hover-opacity:hover {
            opacity: 1 !important;
            color: var(--sigma-blue-light) !important;
            transition: 0.3s;
        }

        #creator::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            background: var(--sigma-blue-primary);
            filter: blur(150px);
            opacity: 0.1;
            z-index: -1;
        }

        /* --- Buttons --- */
        .btn-sigma-main {
            background: linear-gradient(135deg, var(--sigma-blue-primary), var(--sigma-blue-light));
            color: white;
            border: none;
            border-radius: 15px;
            padding: 16px 40px;
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(0, 86, 224, 0.4);
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-sigma-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 86, 224, 0.6);
            color: white;
        }

        .footer-sigma {
            background: #04081a;
            border-top: 1px solid var(--glass-border);
            padding: 40px 0;
        }

        @media (max-width: 991px) {
            #canvas-container { position: relative; width: 100%; height: 350px; }
            .hero-section { text-align: center; padding-top: 120px; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-sigma fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('template/assets/img/SIGMA.png') }}" alt="SIGMA" height="45" class="me-3">
                <span class="text-gradient fs-2">SIGMA</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center">
                    @auth
                        <span class="me-3 opacity-75">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                        <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm rounded-pill px-4">Keluar</a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 fw-bold">Masuk</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div id="canvas-container"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h6 class="text-info fw-bold text-uppercase mb-3" style="letter-spacing: 4px;">Solusi Logistik Cerdas</h6>
                    <h1 class="display-3 fw-bold mb-4">Sistem <span class="text-gradient">Gudang</span> Manajemen</h1>
                    <p class="lead text-secondary mb-5 fs-4">Optimalkan inventaris dan pantau stok secara real-time dengan teknologi visualisasi cerdas.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-sigma-main btn-lg">Mulai Sekarang <i class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5 mb-3">Keunggulan Utama</h2>
                <div class="mx-auto" style="width: 100px; height: 4px; background: var(--sigma-blue-light); border-radius: 10px;"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="icon-3d-box mx-auto mb-4">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Stok Akurat</h4>
                        <p class="opacity-75">Pemantauan barang masuk dan keluar yang tercatat secara otomatis dengan presisi 100%.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="icon-3d-box mx-auto mb-4" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Respon Cepat</h4>
                        <p class="opacity-75">Akses data inventaris kapan saja dan di mana saja melalui dashboard cloud yang responsif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="icon-3d-box mx-auto mb-4" style="background: linear-gradient(135deg, #00b09b, #96c93d);">
                            <i class="fa-solid fa-vault"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Keamanan Berlapis</h4>
                        <p class="opacity-75">Data gudang Anda dilindungi dengan enkripsi tingkat tinggi dan sistem manajemen hak akses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- --- Section: Tim Pengembang (Creator) --- -->
    <section id="creator" class="py-5" style="position: relative;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5 mb-3">Dibalik Layar</h2>
                <p class="text-secondary">Inovasi ini lahir dari semangat kolaborasi kami.</p>
                <div class="mx-auto" style="width: 80px; height: 4px; background: var(--sigma-blue-light); border-radius: 10px;"></div>
            </div>

            <div class="row g-4 justify-content-center">

                 <!-- Creator 2: Bunga (Tengah) -->
                <div class="col-lg-6">
                    <div class="feature-card text-start d-flex align-items-center p-4" style="border-radius: 30px; border: 1px solid rgba(61, 181, 241, 0.3);">
                        <div class="creator-avatar-wrapper me-4">
                            <!-- Ganti src dengan path foto Bunga -->
                            <div class="icon-3d-box mb-0" style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; padding: 0; background: linear-gradient(135deg, #FF4B2B, #FF416C);">
                                <img src="{{ asset('assets/img/foto-bunga.jpg') }}" alt="Bunga" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <div class="creator-info">
                            <h5 class="fw-bold mb-1 text-gradient" style="font-size: 1.1rem;">Bunga Rasmi Marsinta Br Hutagalung</h5>
                            <p class="text-info small mb-2 fw-bold">3312511049</p>
                            <div class="d-flex gap-3">
                                <a href="#" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-brands fa-instagram me-1 text-info"></i> Instagram
                                </a>
                                <a href="#" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-brands fa-github me-1 text-info"></i> GitHub
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Creator 1: Haikal Fadhil -->
                <div class="col-lg-6">
                    <div class="feature-card text-start d-flex align-items-center p-4" style="border-radius: 30px;">
                        <div class="creator-avatar-wrapper me-4">
                            <!-- Ganti src dengan path foto Haikal Fadhil -->
                            <div class="icon-3d-box mb-0" style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; padding: 0;">
                                <img src="{{ asset('assets/img/foto-haikal-fadhil.jpg') }}" alt="Haikal Fadhil" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <div class="creator-info">
                            <h5 class="fw-bold mb-1 text-gradient">Haikal Fadhil</h5>
                            <p class="text-info small mb-2 fw-bold">3312511055</p>
                            <div class="d-flex gap-3">
                                <a href="#" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-brands fa-github me-1 text-info"></i> GitHub
                                </a>
                                <a href="#" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-brands fa-linkedin me-1 text-info"></i> LinkedIn
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Creator 3: Haikal Mubaroq Zafia -->
                <div class="col-lg-6">
                    <div class="feature-card text-start d-flex align-items-center p-4" style="border-radius: 30px;">
                        <div class="creator-avatar-wrapper me-4">
                            <!-- Ganti src dengan path foto Haikal Mubaroq -->
                            <div class="icon-3d-box mb-0" style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; padding: 0; background: linear-gradient(135deg, #2b59c3, #00d2ff);">
                                <img src="{{ asset('template/assets/img/foto-haikal-mubaroq.jpeg') }}" alt="Haikal Mubaroq Zafia" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <div class="creator-info">
                            <h5 class="fw-bold mb-1 text-gradient">Haikal Mubaroq Zafia</h5>
                            <p class="text-info small mb-2 fw-bold">3312501035</p>
                            <div class="d-flex gap-3">
                                <a href="mailto:haikalmubaroq@gmail.com" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-solid fa-envelope me-1 text-info"></i> Email
                                </a>
                                <a href="https://instagram.com/haikalm_z" target="_blank" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-brands fa-instagram me-1 text-info"></i> Instagram
                                </a>
                                <a href="#" class="text-decoration-none text-white opacity-75 small hover-opacity">
                                    <i class="fa-brands fa-github me-1 text-info"></i> GitHub
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer-sigma text-center">
        <div class="container">
            <p class="opacity-50">© 2026 <strong>SIGMA</strong> - Dikembangkan oleh Teknik Informatika Polibatam.</p>
        </div>
    </footer>

    <!-- Three.js Visualisasi 3D -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });

        renderer.setSize(container.clientWidth, container.clientHeight);
        container.appendChild(renderer.domElement);

        const group = new THREE.Group();
        const textureLoader = new THREE.TextureLoader();

        const logoTexture = textureLoader.load("{{ asset('template/assets/img/SIGMA.png') }}");
        const logoGeo = new THREE.PlaneGeometry(5.5, 5.5);
        const logoMat = new THREE.MeshBasicMaterial({ map: logoTexture, transparent: true, side: THREE.DoubleSide });
        const logoPlane = new THREE.Mesh(logoGeo, logoMat);
        group.add(logoPlane);

        const ringGeo = new THREE.TorusGeometry(3.5, 0.05, 16, 100);
        const ringMat = new THREE.MeshPhongMaterial({ color: 0x3db5f1, emissive: 0x0046b8 });
        const ring = new THREE.Mesh(ringGeo, ringMat);
        group.add(ring);

        scene.add(group);

        const light = new THREE.PointLight(0xffffff, 1, 100);
        light.position.set(10, 10, 10);
        scene.add(light);
        scene.add(new THREE.AmbientLight(0xffffff, 0.5));

        camera.position.z = 10;

        function animate() {
            requestAnimationFrame(animate);
            group.rotation.y += 0.01;
            group.rotation.x = Math.sin(Date.now() * 0.001) * 0.1;
            renderer.render(scene, camera);
        }
        animate();

        window.addEventListener('resize', () => {
            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
