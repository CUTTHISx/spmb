# 🎓 PPDB Online - Sistem Penerimaan Peserta Didik Baru

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
    <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
    <img src="https://img.shields.io/badge/TailwindCSS-3.x-cyan.svg" alt="TailwindCSS">
    <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## 📋 Tentang Sistem

Sistem PPDB Online adalah aplikasi web untuk mengelola proses penerimaan peserta didik baru secara digital. Sistem ini dibangun menggunakan Laravel 11 dengan desain modern dan user-friendly.

### ✨ Fitur Utama

- **Multi-Role Authentication** - Admin, Kepala Sekolah, Keuangan, dan Pendaftar
- **Dashboard Interaktif** - Dashboard khusus untuk setiap role
- **Form Pendaftaran Lengkap** - Data pribadi, orang tua, asal sekolah
- **Upload Berkas** - Sistem upload dokumen pendukung
- **Verifikasi Data** - Proses verifikasi oleh admin
- **Laporan & Statistik** - Data pendaftar dan laporan
- **Responsive Design** - Dapat diakses dari berbagai perangkat

## 🚀 Instalasi

### Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL/SQLite)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd ppdb
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## 👥 Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ppdb.com | admin123 |
| Kepala Sekolah | kepsek@ppdb.com | kepsek123 |
| Keuangan | keuangan@ppdb.com | keuangan123 |
| Pendaftar | siswa@ppdb.com | siswa123 |

## 🏗️ Struktur Aplikasi

### Models
- `Pengguna` - Data pengguna sistem
- `Pendaftar` - Data pendaftar
- `PendaftarDataSiswa` - Data pribadi siswa
- `PendaftarDataOrtu` - Data orang tua
- `PendaftarAsalSekolah` - Data asal sekolah
- `PendaftarBerkas` - Berkas upload
- `Gelombang` - Gelombang pendaftaran
- `Jurusan` - Data jurusan
- `LogAktivitas` - Log aktivitas sistem

### Controllers
- `AuthController` - Autentikasi
- `PendaftarController` - Pendaftaran siswa
- `Admin\PendaftarController` - Kelola pendaftar (Admin)

### Middleware
- `CekLogin` - Validasi login
- `CekRole` - Validasi role pengguna

## 🎨 Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, TailwindCSS
- **Database**: SQLite (default), MySQL
- **Icons**: Font Awesome
- **Fonts**: Inter

## 📱 Fitur Dashboard

### Dashboard Pendaftar
- Progress pendaftaran
- Form data pribadi
- Upload berkas
- Status verifikasi

### Dashboard Admin
- Statistik pendaftar
- Kelola data pendaftar
- Verifikasi berkas
- Laporan sistem

### Dashboard Kepala Sekolah
- Overview pendaftaran
- Laporan statistik
- Monitoring proses

### Dashboard Keuangan
- Data pembayaran
- Laporan keuangan
- Verifikasi pembayaran

## 🔧 Konfigurasi

### Database
Edit file `.env` untuk konfigurasi database:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```

### Mail
Konfigurasi email untuk notifikasi:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
```

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

## 📞 Dukungan

Jika Anda memiliki pertanyaan atau membutuhkan bantuan:

- Email: support@ppdb.com
- WhatsApp: +62 812-3456-7890
- Telegram: @ppdb_support

---

**Dibuat dengan ❤️ menggunakan Laravel & TailwindCSS**
