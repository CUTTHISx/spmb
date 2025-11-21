<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PPDB SMK Bakti Nusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        :root { --primary: #2563eb; --secondary: #1e40af; }
        
        /* Navbar */
        .navbar { background: rgba(255,255,255,0.95); box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: all 0.3s; }
        .navbar-brand { font-weight: 700; color: var(--primary); font-size: 1.3rem; }
        .nav-link { color: #333; font-weight: 500; margin: 0 0.5rem; transition: color 0.3s; }
        .nav-link:hover { color: var(--primary); }
        .btn-daftar { background: var(--primary); color: white; padding: 0.5rem 1.5rem; border-radius: 50px; }
        .btn-daftar:hover { background: var(--secondary); transform: translateY(-2px); }
        
        /* Hero */
        .hero { 
            background: linear-gradient(rgba(37,99,235,0.7), rgba(30,64,175,0.8)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920') center/cover; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            color: white; 
        }
        .hero h1 { font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem; }
        .hero p { font-size: 1.2rem; margin-bottom: 2rem; }
        .btn-hero { padding: 1rem 2.5rem; font-size: 1.1rem; border-radius: 50px; margin: 0.5rem; }
        
        /* Section */
        .section-title { font-size: 2.5rem; font-weight: 700; color: var(--primary); margin-bottom: 3rem; position: relative; }
        .section-title::after { content: ''; width: 80px; height: 4px; background: var(--primary); position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); }
        
        /* Card */
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s; height: 100%; }
        .card-custom:hover { transform: translateY(-10px); box-shadow: 0 10px 30px rgba(37,99,235,0.2); }
        .icon-box { width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.8rem; margin: 0 auto 1rem; }
        
        /* Pricing */
        .pricing-card { border: 2px solid #e5e7eb; border-radius: 15px; padding: 2rem; transition: all 0.3s; }
        .pricing-card:hover { border-color: var(--primary); box-shadow: 0 10px 30px rgba(37,99,235,0.15); }
        .price { font-size: 2.5rem; font-weight: 700; color: var(--primary); }
        
        /* Footer */
        .footer { background: var(--secondary); color: white; padding: 3rem 0 1rem; }
        .footer a { color: rgba(255,255,255,0.8); text-decoration: none; }
        .footer a:hover { color: white; }
        .social-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 0.3rem; transition: all 0.3s; }
        .social-icon:hover { background: var(--primary); transform: translateY(-3px); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-mortarboard-fill me-2"></i>SMK BAKNUS 666</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tata-cara">Tata Cara</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jurusan">Jurusan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#harga">Harga Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cek-status">Cek Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-daftar ms-3">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section id="home" class="hero">
        <div class="container text-center">
            <h1 data-aos="fade-up">PPDB SMK BAKTI NUSANTARA 666</h1>
            <p data-aos="fade-up" data-aos-delay="100">Wujudkan Masa Depan Cemerlang Bersama Pendidikan Vokasi Berkualitas</p>
            <div data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('register') }}" class="btn btn-light btn-hero">Daftar Sekarang</a>
                <a href="/login" class="btn btn-outline-light btn-hero">Login</a>
            </div>
        </div>
    </section>

    <!-- Tata Cara -->
    <section id="tata-cara" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">Tata Cara Registrasi</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-person-plus"></i></div>
                        <h5 class="fw-bold">1. Buat Akun</h5>
                        <p class="text-muted">Daftar dengan email aktif Anda</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-pencil-square"></i></div>
                        <h5 class="fw-bold">2. Isi Formulir</h5>
                        <p class="text-muted">Lengkapi data diri dengan benar</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-cloud-upload"></i></div>
                        <h5 class="fw-bold">3. Upload Berkas</h5>
                        <p class="text-muted">Unggah dokumen pendukung</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-credit-card"></i></div>
                        <h5 class="fw-bold">4. Bayar Pendaftaran</h5>
                        <p class="text-muted">Transfer biaya pendaftaran</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-check-circle"></i></div>
                        <h5 class="fw-bold">5. Verifikasi</h5>
                        <p class="text-muted">Tunggu proses verifikasi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-megaphone"></i></div>
                        <h5 class="fw-bold">6. Pengumuman</h5>
                        <p class="text-muted">Cek hasil seleksi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jurusan -->
    <section id="jurusan" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center section-title">Program Jurusan</h2>
            <div class="row g-4">
                @forelse($jurusan as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                @switch($item->kode)
                                    @case('PPLG') <i class="bi bi-laptop"></i> @break
                                    @case('DKV') <i class="bi bi-palette"></i> @break
                                    @case('AKL') @case('AKUNTANSI') <i class="bi bi-calculator"></i> @break
                                    @case('ANIMASI') <i class="bi bi-camera-reels"></i> @break
                                    @case('BDP') <i class="bi bi-graph-up"></i> @break
                                    @default <i class="bi bi-mortarboard"></i>
                                @endswitch
                            </div>
                            <h5 class="fw-bold mb-3">{{ $item->nama }}</h5>
                            <p class="text-muted small mb-3">
                                @switch($item->kode)
                                    @case('PPLG') Pengembangan aplikasi dan game modern @break
                                    @case('DKV') Desain komunikasi visual profesional @break
                                    @case('AKL') @case('AKUNTANSI') Akuntansi dan keuangan bisnis @break
                                    @case('ANIMASI') Animasi dan multimedia kreatif @break
                                    @case('BDP') Bisnis digital dan pemasaran online @break
                                    @default Program keahlian berkualitas
                                @endswitch
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-people me-1"></i>Kuota: {{ $item->kuota }}</small>
                                <span class="badge bg-primary">Sisa: {{ $item->kuota - $item->pendaftar_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center"><p class="text-muted">Belum ada data jurusan</p></div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Harga Daftar -->
    <section id="harga" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">Biaya Pendaftaran</h2>
            @php
                $activeGelombang = App\Models\Gelombang::where('is_active', true)->first();
                $biayaDaftar = $activeGelombang ? $activeGelombang->biaya_daftar : 250000;
            @endphp
            @if($activeGelombang)
            <div class="text-center mb-4">
                <span class="badge bg-primary fs-5 px-4 py-2">
                    <i class="bi bi-calendar-check me-2"></i>{{ $activeGelombang->nama }}
                </span>
                <p class="text-muted mt-2">{{ date('d M Y', strtotime($activeGelombang->tgl_mulai)) }} - {{ date('d M Y', strtotime($activeGelombang->tgl_selesai)) }}</p>
            </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="pricing-card text-center">
                        <h4 class="fw-bold mb-3">Biaya Pendaftaran PPDB</h4>
                        <div class="price mb-3">Rp {{ number_format($biayaDaftar, 0, ',', '.') }}</div>
                        <p class="text-muted mb-4">Biaya pendaftaran sudah termasuk:</p>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Formulir pendaftaran</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Proses verifikasi berkas</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Tes seleksi masuk</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Kartu peserta ujian</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg w-100">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section id="fasilitas" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center section-title">Fasilitas Sekolah</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-pc-display"></i></div>
                        <h6 class="fw-bold">Lab Komputer</h6>
                        <p class="text-muted small mb-0">Komputer modern & internet cepat</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-wifi"></i></div>
                        <h6 class="fw-bold">WiFi Gratis</h6>
                        <p class="text-muted small mb-0">Akses internet di seluruh area</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-book"></i></div>
                        <h6 class="fw-bold">Perpustakaan</h6>
                        <p class="text-muted small mb-0">Koleksi buku lengkap & nyaman</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-building"></i></div>
                        <h6 class="fw-bold">Ruang Kelas AC</h6>
                        <p class="text-muted small mb-0">Kelas nyaman & ber-AC</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-trophy"></i></div>
                        <h6 class="fw-bold">Lapangan Olahraga</h6>
                        <p class="text-muted small mb-0">Fasilitas olahraga lengkap</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-shop"></i></div>
                        <h6 class="fw-bold">Kantin</h6>
                        <p class="text-muted small mb-0">Kantin bersih & higienis</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-camera-video"></i></div>
                        <h6 class="fw-bold">Studio Multimedia</h6>
                        <p class="text-muted small mb-0">Peralatan multimedia profesional</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-custom text-center p-4">
                        <div class="icon-box"><i class="bi bi-bus-front"></i></div>
                        <h6 class="fw-bold">Parkir Luas</h6>
                        <p class="text-muted small mb-0">Area parkir aman & luas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cek Status -->
    <section id="cek-status" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">Cek Status Pendaftaran</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-custom p-4">
                        <div class="text-center mb-4">
                            <div class="icon-box mx-auto mb-3">
                                <i class="bi bi-search"></i>
                            </div>
                            <h5 class="fw-bold">Cek Status Pendaftaran Anda</h5>
                            <p class="text-muted">Masukkan nomor pendaftaran untuk melihat status terkini</p>
                        </div>
                        <form id="cekStatusForm">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nomor Pendaftaran</label>
                                <input type="text" class="form-control form-control-lg" id="noPendaftaran" placeholder="Contoh: PPDB20250001" required>
                                <div class="form-text">Masukkan nomor pendaftaran yang Anda terima saat mendaftar</div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-search me-2"></i>Cek Status
                            </button>
                        </form>
                        
                        <!-- Result Area -->
                        <div id="statusResult" class="mt-4" style="display: none;">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold" id="resultNama"></h6>
                                        <small class="text-muted" id="resultNoPendaftaran"></small>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Jurusan</small>
                                        <span class="fw-semibold" id="resultJurusan"></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Status Verifikasi</small>
                                        <span id="resultVerifikasi"></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Status Pembayaran</small>
                                        <span id="resultPembayaran"></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Hasil Keputusan</small>
                                        <span id="resultKeputusan"></span>
                                    </div>
                                </div>
                                <div class="mt-3" id="resultCatatan" style="display: none;">
                                    <small class="text-muted d-block">Catatan</small>
                                    <p class="mb-0" id="resultCatatanText"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div id="errorResult" class="mt-4" style="display: none;">
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <span id="errorMessage"></span>
                            </div>
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
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card card-custom p-4">
                        <h5 class="fw-bold mb-4">Informasi Kontak</h5>
                        <div class="d-flex mb-3">
                            <div class="icon-box me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Alamat</h6>
                                <p class="text-muted mb-0">Jl. Percobaan Km. 17 No. 65 Cileunyi, Cimekar, Kec. Cileunyi, Kab. Bandung, Jawa Barat</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="icon-box me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Telepon</h6>
                                <p class="text-muted mb-0">(022) 6373-0220</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="icon-box me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">WhatsApp</h6>
                                <p class="text-muted mb-0">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="icon-box me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Email</h6>
                                <p class="text-muted mb-0">baknus@smkbn666.sch.id<br>ppdb@smkbn666.sch.id</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-custom p-0 overflow-hidden" style="height: 100%;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8!2d107.740300000000!3d-6.942100000000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTYnMzEuNiJTIDEwN8KwNDQnMjUuMSJF!5e0!3m2!1sid!2sid!4v1688395801289!5m2!1sid!2sid" width="100%" height="100%" style="border:0; min-height: 350px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-mortarboard-fill me-2"></i>SMK Bakti Nusantara 666</h5>
                    <p class="mb-3">Sekolah Menengah Kejuruan yang berkomitmen memberikan pendidikan vokasi berkualitas untuk masa depan cemerlang.</p>
                    <div>
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#tata-cara">Tata Cara</a></li>
                        <li class="mb-2"><a href="#jurusan">Jurusan</a></li>
                        <li class="mb-2"><a href="#harga">Harga Daftar</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Lainnya</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#fasilitas">Fasilitas</a></li>
                        <li class="mb-2"><a href="#kontak">Kontak</a></li>
                        <li class="mb-2"><a href="#">Syarat & Ketentuan</a></li>
                        <li class="mb-2"><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Jam Operasional</h6>
                    <p class="mb-2"><i class="bi bi-clock me-2"></i>Senin - Jumat: 07.00 - 16.00 WIB</p>
                    <p class="mb-2"><i class="bi bi-clock me-2"></i>Sabtu: 07.00 - 12.00 WIB</p>
                    <p class="mb-0"><i class="bi bi-clock me-2"></i>Minggu: Tutup</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center py-3">
                <p class="mb-0">&copy; 2024 SMK Bakti Nusantara 666. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        
        // Cek Status Form
        document.getElementById('cekStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const noPendaftaran = document.getElementById('noPendaftaran').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Hide previous results
            document.getElementById('statusResult').style.display = 'none';
            document.getElementById('errorResult').style.display = 'none';
            
            // Show loading
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mencari...';
            submitBtn.disabled = true;
            
            fetch('/api/cek-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ no_pendaftaran: noPendaftaran })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show result
                    document.getElementById('resultNama').textContent = data.data.nama;
                    document.getElementById('resultNoPendaftaran').textContent = data.data.no_pendaftaran;
                    document.getElementById('resultJurusan').textContent = data.data.jurusan || '-';
                    
                    // Status badges
                    const verifikasiClass = data.data.status_verifikasi === 'VERIFIED' ? 'success' : 
                                          data.data.status_verifikasi === 'REJECTED' ? 'danger' : 'warning';
                    document.getElementById('resultVerifikasi').innerHTML = 
                        `<span class="badge bg-${verifikasiClass}">${data.data.status_verifikasi_text}</span>`;
                    
                    const pembayaranClass = data.data.status_pembayaran === 'VERIFIED' ? 'success' : 
                                          data.data.status_pembayaran === 'REJECTED' ? 'danger' : 'warning';
                    document.getElementById('resultPembayaran').innerHTML = 
                        `<span class="badge bg-${pembayaranClass}">${data.data.status_pembayaran_text}</span>`;
                    
                    const keputusanClass = data.data.hasil_keputusan === 'LULUS' ? 'success' : 
                                         data.data.hasil_keputusan === 'TIDAK_LULUS' ? 'danger' : 
                                         data.data.hasil_keputusan === 'CADANGAN' ? 'info' : 'secondary';
                    document.getElementById('resultKeputusan').innerHTML = 
                        `<span class="badge bg-${keputusanClass}">${data.data.hasil_keputusan_text}</span>`;
                    
                    // Show notes if available
                    if (data.data.catatan) {
                        document.getElementById('resultCatatanText').textContent = data.data.catatan;
                        document.getElementById('resultCatatan').style.display = 'block';
                    } else {
                        document.getElementById('resultCatatan').style.display = 'none';
                    }
                    
                    document.getElementById('statusResult').style.display = 'block';
                } else {
                    document.getElementById('errorMessage').textContent = data.message;
                    document.getElementById('errorResult').style.display = 'block';
                }
            })
            .catch(error => {
                document.getElementById('errorMessage').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                document.getElementById('errorResult').style.display = 'block';
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>
