<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online - Sekolah Masa Depan</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/pages/welcome.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-mortarboard-fill me-2"></i>SMK Bakti Nusantara 666
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tata-cara">Tata Cara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sejarah">Sejarah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informasi">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jurusan">Jurusan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary ms-lg-3" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); border: none; border-radius: 25px; padding: 8px 20px; color: white; text-decoration: none;">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title fade-in">Penerimaan Peserta Didik Baru</h1>
                    <p class="hero-subtitle fade-in">Membuka pintu masa depan dengan pendidikan berkualitas dan lingkungan belajar yang inspiratif. Bergabunglah dengan komunitas pembelajar di sekolah kami.</p>
                    <div class="fade-in">
                        <a href="{{ route('register') }}" class="btn btn-light btn-hero" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: white; text-decoration: none; padding: 12px 30px; border-radius: 25px;">Daftar Sekarang</a>
                        <a href="/login" class="btn btn-outline-light btn-hero">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tata Cara Registrasi -->
    <section id="tata-cara" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center section-title">Tata Cara Registrasi</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card position-relative">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h4>Buat Akun</h4>
                        <p>Daftarkan diri Anda dengan mengisi formulir pendaftaran online menggunakan email aktif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card position-relative">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h4>Isi Formulir</h4>
                        <p>Lengkapi data diri dan informasi yang diperlukan dengan benar dan lengkap.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card position-relative">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <h4>Upload Berkas</h4>
                        <p>Unggah dokumen yang diperlukan seperti foto, ijazah, dan berkas pendukung lainnya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card position-relative">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h4>Verifikasi</h4>
                        <p>Tunggu proses verifikasi data dan dokumen oleh panitia PPDB.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card position-relative">
                        <div class="step-number">5</div>
                        <div class="step-icon">
                            <i class="bi bi-card-checklist"></i>
                        </div>
                        <h4>Seleksi</h4>
                        <p>Ikuti proses seleksi sesuai dengan ketentuan yang berlaku di sekolah.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card position-relative">
                        <div class="step-number">6</div>
                        <div class="step-icon">
                            <i class="bi bi-megaphone"></i>
                        </div>
                        <h4>Pengumuman</h4>
                        <p>Lihat hasil seleksi melalui website atau pengumuman di sekolah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sejarah Sekolah -->
    <section id="sejarah" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">Sejarah Sekolah</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <p class="lead">SMK Bakti Nusantara 666 adalah sekolah menengah kejuruan swasta yang berlokasi di Cileunyi, Kabupaten Bandung, Jawa Barat. Dengan NPSN 20267919, sekolah ini berkomitmen memberikan pendidikan vokasi berkualitas untuk mempersiapkan lulusan yang siap kerja dan berwirausaha.</p>
                    <p>Sebagai institusi pendidikan kejuruan, kami fokus pada pengembangan keterampilan praktis dan kompetensi yang dibutuhkan dunia industri, dengan didukung fasilitas pembelajaran yang memadai dan tenaga pengajar yang berpengalaman.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h5><i class="bi bi-eye me-2"></i>Visi</h5>
                                    <p class="mb-0">Menjadi SMK unggulan yang menghasilkan lulusan berkarakter, terampil, dan siap bersaing di dunia kerja maupun berwirausaha.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-secondary text-white">
                                <div class="card-body">
                                    <h5><i class="bi bi-bullseye me-2"></i>Misi</h5>
                                    <p class="mb-0">Menyelenggarakan pendidikan kejuruan berkualitas yang mengintegrasikan pembelajaran teori dan praktik sesuai kebutuhan industri.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h5>1995</h5>
                                <p>Pendirian Sekolah EduFuture dengan 3 kelas dan 5 guru.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h5>2005</h5>
                                <p>Penambahan gedung baru dan laboratorium komputer.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h5>2015</h5>
                                <p>Akreditasi A dan penambahan program jurusan keahlian.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h5>2020</h5>
                                <p>Penerapan sistem pembelajaran digital dan hybrid.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h5>2023</h5>
                                <p>Perluasan kampus dan penambahan fasilitas olahraga.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi & Lokasi Sekolah -->
    <section id="informasi" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center section-title">Informasi & Lokasi</h2>
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="card border-0 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Gedung Sekolah">
                        <div class="card-body bg-white p-4">
                            <h4 class="card-title">Profil Sekolah</h4>
                            <p class="card-text">SMK Bakti Nusantara 666 merupakan sekolah kejuruan swasta yang mengedepankan kualitas pendidikan vokasi dengan fasilitas praktik yang memadai dan tenaga pengajar profesional.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Akreditasi A</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Fasilitas Lengkap</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Guru Berpengalaman</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Program Unggulan</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="mb-3">Lokasi Sekolah</h4>
                    <p><i class="bi bi-geo-alt-fill text-primary me-2"></i> Jl. Percobaan Km. 17 No. 65 Cileunyi, Cimekar, Kec. Cileunyi, Kab. Bandung, Jawa Barat</p>
                    <p><i class="bi bi-telephone-fill text-primary me-2"></i> (022) 6373-0220</p>
                    <p><i class="bi bi-clock-fill text-primary me-2"></i> Senin - Jumat: 07.00 - 16.00 WIB</p>
                    
                    <div class="ratio ratio-16x9 mt-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8!2d107.740300000000!3d-6.942100000000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTYnMzEuNiJTIDEwN8KwNDQnMjUuMSJF!5e0!3m2!1sid!2sid!4v1688395801289!5m2!1sid!2sid" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jurusan -->
    <section id="jurusan" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">Program Jurusan</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-sm-6 col-lg-4">
                    <div class="jurusan-card">
                        <div class="jurusan-icon">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <div class="jurusan-content">
                            <h5>PPLG</h5>
                            <p class="small">Pengembangan Perangkat Lunak dan Gim - Fokus pada pemrograman dan pengembangan aplikasi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="jurusan-card">
                        <div class="jurusan-icon">
                            <i class="bi bi-palette"></i>
                        </div>
                        <div class="jurusan-content">
                            <h5>DKV</h5>
                            <p class="small">Desain Komunikasi Visual - Merancang komunikasi visual yang efektif dan menarik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="jurusan-card">
                        <div class="jurusan-icon">
                            <i class="bi bi-calculator"></i>
                        </div>
                        <div class="jurusan-content">
                            <h5>AKUNTANSI</h5>
                            <p class="small">Akuntansi - Mengelola keuangan dan laporan bisnis dengan prinsip akuntansi modern.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="jurusan-card">
                        <div class="jurusan-icon">
                            <i class="bi bi-camera-reels"></i>
                        </div>
                        <div class="jurusan-content">
                            <h5>ANIMASI</h5>
                            <p class="small">Animasi - Membuat konten visual kreatif untuk film, iklan, dan media digital.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="jurusan-card">
                        <div class="jurusan-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="jurusan-content">
                            <h5>BDP</h5>
                            <p class="small">Bisnis Daring dan Pemasaran - Strategi pemasaran digital dan pengelolaan bisnis online.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center section-title">Hubungi Kami</h2>
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="contact-form">
                        <h4 class="mb-4">Kirim Pesan</h4>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" placeholder="Subjek" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="5" placeholder="Pesan" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom w-100">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="mb-4">Informasi Kontak</h4>
                    <div class="d-flex align-items-start mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Telepon</h5>
                            <p class="mb-0">(022) 6373-0220</p>
                            <p class="mb-0">Fax: (022) 6373-0220</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>WhatsApp</h5>
                            <p class="mb-0">+62 812-3456-7890</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Email</h5>
                            <p class="mb-0">baknus@smkbn666.sch.id</p>
                            <p class="mb-0">ppdb@smkbn666.sch.id</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Alamat</h5>
                            <p class="mb-0">Jl. Percobaan Km. 17 No. 65 Cileunyi, Cimekar, Kec. Cileunyi, Kab. Bandung, Jawa Barat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5><i class="bi bi-mortarboard-fill me-2"></i>SMK Bakti Nusantara 666</h5>
                    <p>Sekolah Menengah Kejuruan swasta yang berkomitmen memberikan pendidikan vokasi berkualitas untuk mempersiapkan tenaga kerja terampil dan siap kerja.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#tata-cara">Tata Cara</a></li>
                        <li class="mb-2"><a href="#sejarah">Sejarah</a></li>
                        <li class="mb-2"><a href="#informasi">Informasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5>Lainnya</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#jurusan">Jurusan</a></li>
                        <li class="mb-2"><a href="#kontak">Kontak</a></li>
                        <li class="mb-2"><a href="#">Syarat & Ketentuan</a></li>
                        <li class="mb-2"><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Newsletter</h5>
                    <p>Berlangganan newsletter untuk mendapatkan informasi terbaru tentang PPDB dan kegiatan sekolah.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email Anda">
                        <button class="btn btn-primary" type="button">Berlangganan</button>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 SMK Bakti Nusantara 666. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Designed with <i class="bi bi-heart-fill text-danger"></i> for better education</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Script -->
    <script src="{{ asset('js/pages/welcome.js') }}"></script>
</body>
</html>