<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentArch</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 2rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: #b8b8b8;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .hero-image {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body class="bg-dark text-white">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                {{-- <i class="bi bi-heart-pulse-fill me-2"></i> --}}
                DentArch
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#misi">Misi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>

                <div class="d-flex">
                    <a href="/login" class="btn btn-outline-light me-2">
                        <i class="bi bi-person-fill me-2"></i>
                        Login
                    </a>
                    <a href="/register" class="btn btn-primary">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Bergabung Menuju
                        <span class="text-primary">Perubahan Besar</span>
                        Teknologi Kesehatan Bersama Kami
                    </h1>

                    <p class="hero-subtitle">
                        Kelahiran internet pada tahun 1983 yang merubah fundamental operasional dan pelayanan kesehatan,
                        adalah bentuk perubahan dan adaptasi besar yang terjadi di seluruh dunia.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="/login">
                            <button class="btn btn-primary-custom">
                                <i class="bi bi-rocket-takeoff me-2"></i>
                                Mulai Bergabung
                            </button>
                        </a>
                        {{-- <button class="btn btn-outline-light">
                            <i class="bi bi-play-circle me-2"></i>
                            Pelajari Lebih Lanjut
                        </button> --}}
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="{{ asset('images/landingpage.png') }}" alt="Teknologi Kesehatan" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-5 bg-darker">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4">Perubahan Besar Teknologi Kesehatan</h2>
                    <p class="lead">
                        Perubahan ini membawa manfaat besar dan resiko privasi serta keamanan data, kini dunia kesehatan
                        sedang menghadapi perubahan besar berikutnya, yaitu perubahan dari layanan kesehatan yang
                        berbasis internet terpusat menuju internet yang lebih privasi, aman dan dimiliki bersama.
                    </p>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-shield-check display-4 text-primary mb-3"></i>
                        <h4>Privasi Terjamin</h4>
                        <p>Data kesehatan Anda dilindungi dengan teknologi enkripsi terdepan untuk menjamin privasi dan
                            keamanan.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-people-fill display-4 text-success mb-3"></i>
                        <h4>Kolaborasi Aman</h4>
                        <p>Platform yang memungkinkan tenaga medis berkolaborasi dengan aman dalam ekosistem kesehatan
                            yang terpercaya.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-globe display-4 text-warning mb-3"></i>
                        <h4>Internet Terdesentralisasi</h4>
                        <p>Menuju masa depan internet kesehatan yang tidak terpusat, lebih demokratis dan dimiliki
                            bersama.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="misi" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">Tim Ambisius Kami</h2>
                    <p class="lead">
                        Kami merupakan sebuah tim ambisius beranggotakan 5 orang yang terbentuk di Fakultas Kedokteran
                        Gigi Universitas Hang Tuah Surabaya, dengan misi membawa jutaan tenaga medis di seluruh
                        Indonesia untuk meningkatkan privasi dan keamanan data mereka dengan mudah dan terjangkau.
                    </p>

                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="display-6 text-primary">5</h3>
                                <p class="mb-0">Anggota Tim</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="display-6 text-success">1M+</h3>
                                <p class="mb-0">Target Tenaga Medis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="feature-card">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-hospital display-6 text-primary me-3"></i>
                            <div>
                                <h4>Universitas Hang Tuah Surabaya</h4>
                                <p class="mb-0 text-muted">Fakultas Kedokteran Gigi</p>
                            </div>
                        </div>
                        <p>
                            Lahir dari lingkungan akademis terbaik, kami berkomitmen untuk menciptakan solusi teknologi
                            kesehatan yang inovatif dan dapat diakses oleh seluruh tenaga medis Indonesia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    {{-- <section class="py-5 bg-primary">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Siap Bergabung dalam Perubahan?</h2>
            <p class="lead mb-4">
                Mari bersama-sama membangun masa depan teknologi kesehatan yang lebih aman, privat, dan terjangkau untuk
                seluruh Indonesia.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button class="btn btn-light btn-lg">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Hubungi Kami
                </button>
                <button class="btn btn-outline-light btn-lg">
                    <i class="bi bi-download me-2"></i>
                    Unduh Materi
                </button>
            </div>
        </div>
    </section> --}}

    <!-- Footer -->
    <footer id="kontak" class="bg-dark py-4">
        <div class="container">
            {{-- <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-heart-pulse-fill me-2"></i>DentArch</h5>
                    <p class="text-muted">Membangun masa depan teknologi kesehatan yang lebih aman dan privat.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end gap-3">
                        <a href="#" class="text-light"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div> --}}
            <hr class="my-3 text-muted">
            <div class="text-center text-muted">
                <p>&copy; 2025 DentArch. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-dark');
                navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
            } else {
                navbar.style.backgroundColor = 'transparent';
            }
        });
    </script>
</body>

</html>
