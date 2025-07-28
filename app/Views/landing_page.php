<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Link CSS Framework seperti Bootstrap, Tailwind CSS, atau custom CSS Anda -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>"> <!-- Pastikan file ini ada di public/css/style.css -->
    <style>
        /* CSS kustom untuk styling */
        .hero-section {
            /* Menggunakan base_url() untuk memastikan path gambar benar */
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= base_url('images/hero-bg.JPG') ?>') no-repeat center center/cover;
            color: white;
            padding: 100px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .cta-button {
            background-color: #0d6efd; /* Warna biru */
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .card-court {
            transition: transform 0.2s;
            cursor: pointer;
        }
        .card-court:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="p-3 bg-white shadow-sm fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="<?= base_url('/') ?>" class="navbar-brand fw-bold fs-4 text-dark">Get Futsal</a>
            <nav class="d-none d-md-block">
                <a href="#home" class="text-decoration-none text-dark mx-3">Beranda</a>
                <a href="#lapangan" class="text-decoration-none text-dark mx-3">Lapangan</a>
                <a href="#kontak" class="text-decoration-none text-dark mx-3">Kontak</a>
            </nav>
            <!-- Mengarahkan ke halaman login -->
            <a href="<?= base_url('login') ?>" class="btn btn-primary cta-button">LOGIN</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-section text-center text-white d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h1 class="display-3 fw-bold mb-4">Booking Lapangan Futsal Tanpa Ribet, Cuma di Get Futsal!</h1>
                    <p class="lead mb-5">Temukan dan pesan lapangan futsal terbaik di kota Batang dalam hitungan detik. Cepat, mudah, dan terpercaya.</p>
                    <div class="card p-4 shadow-lg bg-white bg-opacity-75">
                        <!-- Action form ini perlu disesuaikan dengan rute pencarian lapangan yang akan Anda buat -->
                        <form action="#" method="GET"> 
                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label fw-bold text-dark">Tanggal</label>
                                    <input type="date" class="form-control form-control-lg" id="tanggal" required>
                                </div>
                                <div class="col-md-6">
                                    <a href="#lapangan" type="submit" class="btn btn-primary btn-lg w-100 cta-button">Cari Lapangan</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan Section -->
    <section id="fitur" class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-5">Kenapa Harus Get Futsal?</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <!-- Menggunakan base_url() untuk path ikon -->
                    
                    <h5 class="fw-bold">Pesan Cepat</h5>
                    <p class="text-muted">Pesan lapangan hanya dalam 3 langkah mudah.</p>
                </div>
                <div class="col-md-3 mb-4">
                   
                    <h5 class="fw-bold">Lapangan Lengkap</h5>
                    <p class="text-muted">Pilih dari berbagai lapangan dengan fasilitas terbaik.</p>
                </div>
                <div class="col-md-3 mb-4">
                    
                    <h5 class="fw-bold">Harga Transparan</h5>
                    <p class="text-muted">Tidak ada biaya tersembunyi. Harga ditampilkan jelas.</p>
                </div>
                <div class="col-md-3 mb-4">
                    
                    <h5 class="fw-bold">Pembayaran Aman</h5>
                    <p class="text-muted">Transaksi aman dan nyaman dengan berbagai metode.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Lapangan Populer -->
    <section id="lapangan" class="py-5">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">Daftar Lapangan Tersedia</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php if (!empty($lapangan)): ?>
                    <?php foreach ($lapangan as $l): ?>
                        <div class="col">
                            <div class="card card-court h-100 shadow-sm rounded-4 overflow-hidden border-0">
                                <img src="<?= base_url('uploads/lapangan/' . $l['foto']) ?>" 
                                    class="card-img-top" 
                                    alt="<?= esc($l['nama']) ?>" 
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= esc($l['nama']) ?></h5>
                                    <p class="card-text">Harga: <strong>Rp<?= number_format($l['harga_per_jam']) ?></strong> / jam</p>
                                    <p class="card-text"><?= isset($l['deskripsi']) ? esc($l['deskripsi']) : 'Deskripsi belum tersedia' ?></p>
                                    <a href="<?= base_url('pelanggan/pemesanan/detail/' . $l['id']) ?>" class="btn btn-primary w-100">
                                        Lihat Detail & Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="lead text-muted">Belum ada lapangan yang tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section id="testimoni" class="py-5 bg-light">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">Apa Kata Mereka?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <blockquote class="blockquote">
                        <p class="mb-0 fst-italic">"Situsnya gampang banget dipakai. Cuma butuh 2 menit buat booking lapangan. Top!"</p>
                        <footer class="blockquote-footer mt-2">Budi, <cite title="Source Title">Pemain Futsal</cite></footer>
                    </blockquote>
                </div>
                <div class="col-md-4 mb-4">
                    <blockquote class="blockquote">
                        <p class="mb-0 fst-italic">"Pilihan lapangannya banyak dan harganya jujur. Rekomen banget!"</p>
                        <footer class="blockquote-footer mt-2">Candra, <cite title="Source Title">Mahasiswa</cite></footer>
                    </blockquote>
                </div>
                <div class="col-md-4 mb-4">
                    <blockquote class="blockquote">
                        <p class="mb-0 fst-italic">"Pembayarannya aman, langsung dapat konfirmasi. Sangat membantu!"</p>
                        <footer class="blockquote-footer mt-2">Dewi, <cite title="Source Title">Penyelenggara Acara</cite></footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
    

    <!-- CTA Akhir -->
    <section id="cta-akhir" class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3">Siap Main Hari Ini?</h2>
            <p class="lead mb-4">Jangan sampai kehabisan slot. Booking lapangan favoritmu sekarang juga di Get Futsal!</p>
            <!-- Mengarahkan ke halaman login dan mengubah warna teks tombol menjadi putih -->
            <a href="<?= base_url('login') ?>" class="btn btn-light btn-lg cta-button text-white">Pesan Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Get Futsal</h5>
                    <p class="">Platform booking lapangan futsal terbaik di Kabupaten Batang.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Informasi Kontak</h5>
                    <ul class="list-unstyled ">
                        <li><i class="bi bi-envelope-fill me-2"></i>info@getfutsal.com</li>
                        <li><i class="bi bi-telephone-fill me-2"></i>0852-9372-4983</li>
                        <li><i class="bi bi-geo-alt-fill me-2"></i>Jl. Raya Tegalsari, Tegalsari, Kandeman, Kab.Batang</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center ">
                <p class="mb-0">&copy; 2025 Get Futsal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Anda juga bisa menambahkan script JavaScript custom di sini -->
</body>
</html>
