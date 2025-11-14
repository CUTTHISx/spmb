# 🎓 Sistem PPDB Online - Dokumentasi Fitur

## 👥 Role & Akses

### 🎯 Pendaftar/Calon Siswa
- **Registrasi Akun** - Daftar dengan email/HP + password/OTP
- **Formulir Pendaftaran** - Data siswa, ortu, asal sekolah, alamat + koordinat
- **Upload Berkas** - Ijazah, rapor, KIP, KKS, akta, KK (PDF/JPG)
- **Status Pendaftaran** - Timeline: Draft → Dikirim → Verifikasi → Pembayaran → Lulus
- **Pembayaran** - Nominal, instruksi, upload bukti, VA/QRIS
- **Cetak Kartu/Resume** - PDF kartu pendaftaran & bukti bayar

### 👨‍💼 Admin Panitia
- **Dashboard Operasional** - Ringkasan harian, grafik per jurusan/gelombang
- **Master Data** - Jurusan, kuota, gelombang, biaya, syarat berkas, wilayah
- **Monitoring Berkas** - Daftar pendaftar, filter, sort, export
- **Peta Sebaran** - Map interaktif domisili pendaftar per wilayah/jurusan

### ✅ Verifikator Administrasi
- **Verifikasi Administrasi** - Cek data/berkas, status Lulus/Tolak/Perbaikan + catatan

### 💰 Bagian Keuangan
- **Verifikasi Pembayaran** - Validasi bukti bayar, status Terbayar/Reject + alasan
- **Rekap Keuangan** - Laporan pemasukan per gelombang/jurusan/periode (Excel/PDF)

### 🏢 Kepala Sekolah/Yayasan
- **Dashboard Eksekutif** - KPI: pendaftar vs kuota, tren, rasio verifikasi, komposisi

## 🔧 Fitur Global

### 📊 Laporan
- Export data pendaftar, status, pembayaran
- Filter per jurusan, gelombang, periode
- Format PDF/Excel

### 🔔 Notifikasi
- **Email/WhatsApp/SMS** untuk:
  - Aktivasi akun
  - Permintaan perbaikan berkas
  - Instruksi pembayaran
  - Hasil verifikasi
- Log pengiriman notifikasi

### 📝 Audit Log
- Pencatatan semua aksi penting
- Tracking: siapa, kapan, apa yang dilakukan
- Jejak audit lengkap

## 📋 Status Flow

```
Draft → Dikirim → Verifikasi Administrasi → Menunggu Pembayaran → 
Terbayar → Verifikasi Keuangan → Lulus/Tidak Lulus/Cadangan
```

## 🗂️ Master Data

### Jurusan
- Nama jurusan
- Kode jurusan
- Kuota per gelombang
- Syarat khusus

### Gelombang
- Nama gelombang
- Tanggal buka/tutup
- Biaya pendaftaran
- Status aktif

### Wilayah
- Kecamatan
- Kelurahan
- Kode pos
- Koordinat

### Berkas Wajib
- Ijazah/SKHUN
- Rapor semester terakhir
- Kartu Keluarga
- Akta kelahiran
- Foto 3x4
- KIP/KKS (opsional)

## 🔐 Keamanan & Validasi

### Upload Berkas
- Format: PDF, JPG, PNG
- Ukuran maksimal: 2MB per file
- Validasi tipe file
- Scan virus otomatis

### Data Validation
- Email format validation
- Phone number validation
- Required field validation
- File size & type validation

## 📱 Notifikasi Template

### Email Templates
- Welcome & activation
- Document verification
- Payment instruction
- Status updates

### SMS/WhatsApp Templates
- OTP verification
- Payment reminders
- Status notifications
- Important announcements