# 📚 USER GUIDE - PPDB ONLINE

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Alur Sistem](#alur-sistem)
3. [Akses Sistem](#akses-sistem)
4. [Panduan untuk Pendaftar](#panduan-untuk-pendaftar)
5. [Panduan untuk Admin](#panduan-untuk-admin)
6. [Panduan untuk Verifikator](#panduan-untuk-verifikator)
7. [Panduan untuk Keuangan](#panduan-untuk-keuangan)
8. [Panduan untuk Kepala Sekolah](#panduan-untuk-kepala-sekolah)
9. [FAQ](#faq)
10. [Troubleshooting](#troubleshooting)

---

## Pendahuluan

### Tentang Sistem
PPDB Online adalah sistem penerimaan peserta didik baru berbasis web yang memudahkan proses pendaftaran siswa baru secara digital.

### Fitur Utama
- ✅ Pendaftaran online 24/7
- ✅ Upload berkas digital
- ✅ Verifikasi administrasi otomatis
- ✅ Pembayaran online
- ✅ Tracking status pendaftaran
- ✅ Dashboard monitoring real-time

### Persyaratan Sistem
- Browser: Chrome, Firefox, Safari, Edge (versi terbaru)
- Koneksi internet stabil
- Email aktif
- File berkas dalam format JPG/PNG/PDF (max 2MB)

---

## Alur Sistem

### 🔄 Alur Lengkap PPDB Online

#### FASE 1: Persiapan Sistem (Admin)

```
┌─────────────────────────────────────┐
│  1. Admin Setup Sistem              │
├─────────────────────────────────────┤
│  ✓ Buat Gelombang Pendaftaran       │
│    - Tentukan tanggal mulai/selesai │
│    - Set biaya pendaftaran          │
│    - Tentukan kuota                 │
│                                     │
│  ✓ Setup Jurusan                    │
│    - Tambah jurusan yang tersedia   │
│    - Set kuota per jurusan          │
│                                     │
│  ✓ Buat Akun Staff                  │
│    - Verifikator                    │
│    - Keuangan                       │
│    - Kepala Sekolah                 │
└─────────────────────────────────────┘
```

#### FASE 2: Pendaftaran (Calon Siswa)

```
┌─────────────────────────────────────┐
│  STEP 1: Registrasi Akun            │
├─────────────────────────────────────┤
│  Calon siswa → Buka website         │
│  → Klik "Daftar Sekarang"           │
│  → Isi: Nama, Email, Password       │
│  → Akun dibuat ✓                    │
│                                     │
│  STATUS: DRAFT                      │
└─────────────────────────────────────┘
         ↓
┌─────────────────────────────────────┐
│  STEP 2: Login & Isi Data Pribadi   │
├─────────────────────────────────────┤
│  → Login dengan email/password      │
│  → Isi Data Siswa:                  │
│    • Nama lengkap                   │
│    • NIK, NISN                      │
│    • Tempat/Tanggal lahir           │
│    • Alamat, No HP                  │
│    • Pilih Jurusan                  │
│                                     │
│  → Isi Data Orang Tua:              │
│    • Nama Ayah/Ibu                  │
│    • Pekerjaan                      │
│    • Penghasilan                    │
│                                     │
│  → Isi Asal Sekolah:                │
│    • Nama sekolah SMP               │
│    • NPSN                           │
│    • Alamat sekolah                 │
│                                     │
│  STATUS: DRAFT (masih bisa edit)    │
└─────────────────────────────────────┘
         ↓
┌─────────────────────────────────────┐
│  STEP 3: Upload Berkas              │
├─────────────────────────────────────┤
│  → Upload dokumen:                  │
│    ✓ Foto 3x4                       │
│    ✓ Kartu Keluarga                 │
│    ✓ Akta Kelahiran                 │
│    ✓ Ijazah SMP                     │
│    ✓ Rapor Semester 1-5             │
│                                     │
│  Format: JPG/PNG/PDF (max 2MB)      │
│                                     │
│  STATUS: DRAFT                      │
└─────────────────────────────────────┘
         ↓
┌─────────────────────────────────────┐
│  STEP 4: Submit Pendaftaran         │
├─────────────────────────────────────┤
│  → Review semua data                │
│  → Klik "Submit Pendaftaran"        │
│  → Data terkunci (tidak bisa edit)  │
│                                     │
│  STATUS: SUBMITTED ✓                │
│  (Menunggu Verifikasi Administrasi) │
└─────────────────────────────────────┘
```

#### FASE 3: Verifikasi Administrasi (Verifikator)

```
┌─────────────────────────────────────┐
│  Verifikator Login                  │
├─────────────────────────────────────┤
│  → Lihat daftar pendaftar baru      │
│  → Klik "Verifikasi" pada pendaftar │
│                                     │
│  Cek Kelengkapan:                   │
│  ✓ Data pribadi lengkap?            │
│  ✓ NIK & NISN valid?                │
│  ✓ Data orang tua lengkap?          │
│  ✓ Semua berkas terupload?          │
│  ✓ Berkas jelas & terbaca?          │
│                                     │
│  KEPUTUSAN:                         │
│  ┌─────────────┬─────────────┐      │
│  │   TERIMA    │    TOLAK    │      │
│  └─────────────┴─────────────┘      │
└─────────────────────────────────────┘
         ↓                    ↓
    ┌─────────┐         ┌──────────┐
    │ LULUS   │         │ DITOLAK  │
    └─────────┘         └──────────┘
         ↓                    ↓
  STATUS:              STATUS:
  VERIFIED_ADM         REJECTED_ADM
  (Lanjut bayar)       (Perbaiki data)
```

**Jika DITOLAK:**
- Pendaftar dapat notifikasi
- Lihat catatan penolakan
- Perbaiki data/berkas
- Submit ulang
- Kembali ke verifikasi

**Jika DITERIMA:**
- Lanjut ke pembayaran ↓

#### FASE 4: Pembayaran (Calon Siswa)

```
┌─────────────────────────────────────┐
│  STEP 5: Proses Pembayaran          │
├─────────────────────────────────────┤
│  → Login ke dashboard               │
│  → Buka menu "Pembayaran"           │
│  → Lihat nominal & rekening tujuan  │
│                                     │
│  Rekening:                          │
│  Bank BCA                           │
│  No. Rek: 1234567890                │
│  A.n: SMK BAKNUS 666                │
│  Nominal: Rp 250.000                │
│                                     │
│  → Transfer via mobile banking      │
│  → Screenshot bukti transfer        │
│  → Upload bukti ke sistem           │
│                                     │
│  STATUS: WAITING_PAYMENT            │
│  (Menunggu Verifikasi Keuangan)     │
└─────────────────────────────────────┘
```

#### FASE 5: Verifikasi Pembayaran (Keuangan)

```
┌─────────────────────────────────────┐
│  Staff Keuangan Login               │
├─────────────────────────────────────┤
│  → Buka "Verifikasi Bayar"          │
│  → Lihat daftar pembayaran masuk    │
│  → Klik "Lihat" bukti transfer      │
│                                     │
│  Cek Pembayaran:                    │
│  ✓ Nominal sesuai?                  │
│  ✓ Tanggal transfer valid?          │
│  ✓ Nama pengirim sesuai?            │
│  ✓ Rekening tujuan benar?           │
│                                     │
│  KEPUTUSAN:                         │
│  ┌─────────────┬─────────────┐      │
│  │   TERIMA    │    TOLAK    │      │
│  └─────────────┴─────────────┘      │
└─────────────────────────────────────┘
         ↓                    ↓
    ┌─────────┐         ┌──────────┐
    │ LUNAS   │         │ DITOLAK  │
    └─────────┘         └──────────┘
         ↓                    ↓
  STATUS:              STATUS:
  VERIFIED_PAYMENT     REJECTED_PAYMENT
  (Pendaftaran Selesai) (Upload ulang bukti)
```

#### FASE 6: Monitoring (Kepala Sekolah)

```
┌─────────────────────────────────────┐
│  Dashboard Kepala Sekolah           │
├─────────────────────────────────────┤
│  Melihat:                           │
│  📊 Total Pendaftar vs Kuota        │
│  📈 Grafik Pendaftaran Harian       │
│  💰 Total Pemasukan                 │
│  ✅ Rasio Verifikasi                │
│  🏫 Asal Sekolah Terbanyak          │
│  📑 Distribusi per Jurusan          │
│                                     │
│  → Generate Laporan Eksekutif       │
│  → Export ke Excel/PDF              │
└─────────────────────────────────────┘
```

### 📊 Diagram Alur Lengkap

```
CALON SISWA                VERIFIKATOR              KEUANGAN              KEPALA SEKOLAH
     │                          │                       │                        │
     │ 1. Registrasi            │                       │                        │
     ├──────────────────────────┤                       │                        │
     │ 2. Isi Data & Upload     │                       │                        │
     ├──────────────────────────┤                       │                        │
     │ 3. Submit                │                       │                        │
     │                          │                       │                        │
     │                          │ 4. Verifikasi Data    │                        │
     │                          ├───────────────────────┤                        │
     │                          │ ✓ Terima / ✗ Tolak    │                        │
     │                          │                       │                        │
     │ 5. Transfer Bayar        │                       │                        │
     ├──────────────────────────┼───────────────────────┤                        │
     │ 6. Upload Bukti          │                       │                        │
     │                          │                       │                        │
     │                          │                       │ 7. Verifikasi Bayar    │
     │                          │                       ├────────────────────────┤
     │                          │                       │ ✓ Terima / ✗ Tolak     │
     │                          │                       │                        │
     │ 8. Pendaftaran Selesai ✓ │                       │                        │
     │                          │                       │                        │
     │                          │                       │                        │ 9. Monitoring
     │                          │                       │                        ├──────────────
     │                          │                       │                        │ • Dashboard
     │                          │                       │                        │ • Laporan
     │                          │                       │                        │ • Statistik
```

### 🎯 Status Pendaftaran

```
DRAFT → SUBMITTED → VERIFIED_ADM → WAITING_PAYMENT → VERIFIED_PAYMENT
  ↓         ↓            ↓               ↓                  ↓
Bisa     Terkunci   Lulus Adm      Sudah Bayar        SELESAI ✓
Edit                                                   (Diterima)

                    ↓ (jika ditolak)
              REJECTED_ADM / REJECTED_PAYMENT
                    ↓
              Perbaiki & Submit Ulang
```

### ⏱️ Timeline Proses

```
Hari 1:  Pendaftar registrasi & isi data
         ↓
Hari 2:  Upload berkas & submit
         ↓
Hari 3-5: Verifikasi administrasi (1-3 hari kerja)
         ↓
Hari 6:  Transfer pembayaran
         ↓
Hari 7:  Verifikasi pembayaran (1x24 jam)
         ↓
Hari 8:  PENDAFTARAN SELESAI ✓
```

### 💡 Poin Penting

1. **Pendaftar** hanya bisa edit data saat status DRAFT
2. **Verifikator** cek kelengkapan data & berkas
3. **Keuangan** verifikasi pembayaran
4. **Admin** kelola sistem & data master
5. **Kepala Sekolah** monitoring & laporan
6. Setiap penolakan harus disertai catatan
7. Notifikasi otomatis ke email pendaftar
8. Data terenkripsi & aman

---

## Akses Sistem

### URL Sistem
```
http://127.0.0.1:8000
```

### Akun Default (untuk testing)
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ppdb.com | admin123 |
| Kepala Sekolah | kepsek@ppdb.com | kepsek123 |
| Keuangan | keuangan@ppdb.com | keuangan123 |
| Pendaftar | siswa@ppdb.com | siswa123 |

---

## Panduan untuk Pendaftar

### 1. Registrasi Akun

![Halaman Utama](../public/images/user-guide/127.0.0.1_8000_.png)
*Halaman utama PPDB Online*

#### Langkah-langkah:
1. Buka halaman utama PPDB Online
2. Klik tombol **"Daftar Sekarang"**
3. Isi formulir registrasi:
   - Nama Lengkap
   - Email aktif
   - Password (minimal 8 karakter)
   - Konfirmasi Password
4. Centang "Saya setuju dengan syarat dan ketentuan"
5. Klik **"Daftar Akun"**
6. Cek email untuk verifikasi (jika ada)

![Halaman Registrasi](../public/images/user-guide/127.0.0.1_8000_register.png)
*Form registrasi akun baru*

#### Tips:
- Gunakan email yang aktif dan sering diakses
- Buat password yang kuat (kombinasi huruf, angka, simbol)
- Simpan password dengan aman

### 2. Login ke Sistem

![Halaman Login](../public/images/user-guide/127.0.0.1_8000_login.png)
*Halaman login PPDB Online*

#### Langkah-langkah:
1. Klik **"Login"** di halaman utama
2. Masukkan email dan password
3. Centang "Ingat saya" jika menggunakan perangkat pribadi
4. Klik **"Masuk ke Dashboard"**

### 3. Mengisi Data Pribadi

![Dashboard Pendaftar](../public/images/user-guide/127.0.0.1_8000_dashboard_pendaftar.png)
*Dashboard utama pendaftar*

![Form Pendaftaran](../public/images/user-guide/127.0.0.1_8000_pendaftaran_formulir.png)
*Form pengisian data pendaftaran*

#### Langkah-langkah:
1. Setelah login, buka menu **"Data Pribadi"**
2. Isi formulir dengan lengkap:
   - **Data Siswa**: Nama, NIK, NISN, Tempat/Tanggal Lahir, dll
   - **Data Orang Tua**: Nama Ayah/Ibu, Pekerjaan, Penghasilan
   - **Asal Sekolah**: Nama sekolah, NPSN, Alamat
3. Klik **"Simpan"** setelah selesai

#### Catatan Penting:
- ⚠️ Pastikan data yang diisi benar dan sesuai dokumen
- ⚠️ NIK dan NISN harus valid
- ⚠️ Nomor HP harus aktif untuk notifikasi

### 4. Upload Berkas

![Upload Berkas](../public/images/user-guide/127.0.0.1_8000_pendaftaran (1).png)
*Halaman upload berkas pendaftaran*

#### Berkas yang Diperlukan:
- ✅ Foto 3x4 (background merah/biru)
- ✅ Kartu Keluarga (KK)
- ✅ Akta Kelahiran
- ✅ Ijazah/SKHUN SMP
- ✅ Rapor Semester 1-5

#### Langkah-langkah:
1. Buka menu **"Upload Berkas"**
2. Klik **"Pilih File"** untuk setiap jenis berkas
3. Pilih file dari komputer (JPG/PNG/PDF, max 2MB)
4. Klik **"Upload"** untuk setiap berkas
5. Tunggu hingga status berubah menjadi "Berhasil"

#### Tips Upload:
- Scan dokumen dengan jelas dan tidak blur
- Pastikan ukuran file tidak melebihi 2MB
- Gunakan format JPG, PNG, atau PDF
- Foto harus terlihat jelas dan tidak terpotong

### 5. Pembayaran

![Halaman Pembayaran](../public/images/user-guide/127.0.0.1_8000_pendaftaran_pembayaran.png)
*Halaman pembayaran dan upload bukti transfer*

#### Langkah-langkah:
1. Setelah data dan berkas lengkap, buka menu **"Pembayaran"**
2. Lihat nominal biaya pendaftaran
3. Transfer ke rekening yang tertera:
   ```
   Bank BCA
   No. Rek: 1234567890
   A.n: SMK BAKNUS 666
   ```
4. Upload bukti transfer:
   - Klik **"Upload Bukti Pembayaran"**
   - Pilih foto/screenshot bukti transfer
   - Klik **"Simpan"**
5. Tunggu verifikasi dari bagian keuangan (1x24 jam)

#### Catatan:
- Simpan bukti transfer asli
- Nominal transfer harus sesuai dengan biaya pendaftaran
- Jika ada perbedaan, hubungi bagian keuangan

### 6. Cek Status Pendaftaran

#### Status yang Mungkin Muncul:
- 🟡 **DRAFT**: Belum submit, masih bisa edit
- 🟠 **SUBMITTED**: Sudah submit, menunggu verifikasi
- 🔵 **VERIFIED_ADM**: Lulus verifikasi administrasi
- 🟢 **VERIFIED_PAYMENT**: Pembayaran terverifikasi
- 🔴 **REJECTED**: Ditolak (lihat catatan)

#### Cara Cek Status:
1. Login ke dashboard
2. Lihat **Progress Pendaftaran** di halaman utama
3. Atau buka menu **"Status Pendaftaran"**

---

## Panduan untuk Admin

### 1. Dashboard Admin

![Dashboard Admin](../public/images/user-guide/127.0.0.1_8000_dashboard_admin.png)
*Dashboard admin dengan statistik lengkap*

![Monitoring](../public/images/user-guide/127.0.0.1_8000_admin_monitoring.png)
*Monitoring pendaftaran real-time*

#### Fitur Dashboard:
- Statistik pendaftar real-time
- Grafik pendaftaran per hari
- Data per jurusan
- Quick actions

### 2. Kelola Data Pendaftar

#### Melihat Daftar Pendaftar:
1. Login sebagai Admin
2. Buka menu **"Data Pendaftar"**
3. Gunakan filter untuk mencari:
   - Status pendaftaran
   - Jurusan
   - Gelombang
   - Nama/No. Pendaftaran

#### Verifikasi Data:
1. Klik tombol **"Detail"** pada pendaftar
2. Periksa kelengkapan data:
   - Data pribadi
   - Data orang tua
   - Asal sekolah
   - Berkas upload
3. Klik **"Verifikasi"** jika data lengkap
4. Atau klik **"Tolak"** dan beri catatan jika ada yang kurang

### 3. Manajemen Akun

![Manajemen Akun](../public/images/user-guide/127.0.0.1_8000_admin_akun.png)
*Halaman manajemen akun pengguna*

#### Menambah Akun Baru:
1. Buka menu **"Manajemen Akun"**
2. Klik **"Tambah Akun"**
3. Isi formulir:
   - Nama Lengkap
   - Email
   - Role (Admin/Keuangan/Verifikator)
   - Password
4. Klik **"Simpan"**

#### Mengedit Akun:
1. Cari akun yang ingin diedit
2. Klik tombol **"Edit"**
3. Ubah data yang diperlukan
4. Klik **"Update"**

#### Menghapus Akun:
1. Klik tombol **"Hapus"** pada akun
2. Konfirmasi penghapusan
3. Akun akan dihapus permanen

### 4. Kelola Gelombang

![Master Data](../public/images/user-guide/127.0.0.1_8000_admin_master.png)
*Halaman master data gelombang dan jurusan*

#### Membuat Gelombang Baru:
1. Buka menu **"Gelombang"**
2. Klik **"Tambah Gelombang"**
3. Isi data:
   - Nama Gelombang (contoh: Gelombang 1)
   - Tanggal Mulai
   - Tanggal Selesai
   - Biaya Pendaftaran
   - Kuota
4. Klik **"Simpan"**

#### Mengaktifkan Gelombang:
1. Pilih gelombang yang ingin diaktifkan
2. Klik toggle **"Aktif"**
3. Hanya 1 gelombang yang bisa aktif

### 5. Kelola Jurusan

#### Menambah Jurusan:
1. Buka menu **"Jurusan"**
2. Klik **"Tambah Jurusan"**
3. Isi data:
   - Kode Jurusan
   - Nama Jurusan
   - Kuota
   - Deskripsi
4. Klik **"Simpan"**

### 6. Laporan

#### Membuat Laporan:
1. Buka menu **"Laporan"**
2. Pilih jenis laporan:
   - Laporan Pendaftar
   - Laporan Pembayaran
   - Laporan per Jurusan
3. Pilih periode/filter
4. Klik **"Generate Laporan"**
5. Download dalam format Excel/PDF

---

## Panduan untuk Verifikator

### 1. Verifikasi Administrasi

![Dashboard Verifikator](../public/images/user-guide/127.0.0.1_8000_dashboard_verifikator.png)
*Dashboard verifikator*

![Daftar Verifikasi](../public/images/user-guide/127.0.0.1_8000_verifikator_verifikasi.png)
*Daftar pendaftar yang perlu diverifikasi*

![Detail Pendaftar](../public/images/user-guide/127.0.0.1_8000_verifikator_detail_35.png)
*Detail data pendaftar untuk verifikasi*

#### Langkah-langkah:
1. Login sebagai Verifikator
2. Buka menu **"Verifikasi Administrasi"**
3. Lihat daftar pendaftar yang perlu diverifikasi
4. Klik **"Verifikasi"** pada pendaftar

#### Checklist Verifikasi:
- ✅ Data pribadi lengkap dan valid
- ✅ NIK dan NISN sesuai
- ✅ Data orang tua lengkap
- ✅ Asal sekolah terisi
- ✅ Semua berkas terupload
- ✅ Berkas jelas dan terbaca

#### Keputusan Verifikasi:
1. **Lulus Administrasi**:
   - Klik **"Terima"**
   - Status berubah menjadi VERIFIED_ADM
   
2. **Ditolak**:
   - Klik **"Tolak"**
   - Isi catatan penolakan dengan jelas
   - Pendaftar akan menerima notifikasi

### 2. Melihat Detail Berkas

#### Cara Melihat Berkas:
1. Klik nama pendaftar
2. Scroll ke bagian **"Berkas Upload"**
3. Klik **"Lihat"** pada setiap berkas
4. Berkas akan ditampilkan dalam modal/tab baru

#### Tips Verifikasi Berkas:
- Zoom untuk melihat detail
- Pastikan foto tidak blur
- Cek kesesuaian data dengan dokumen
- Perhatikan tanggal dan tanda tangan

---

## Panduan untuk Keuangan

### 1. Verifikasi Pembayaran

![Dashboard Keuangan](../public/images/user-guide/127.0.0.1_8000_dashboard_keuangan.png)
*Dashboard keuangan*

![Verifikasi Pembayaran](../public/images/user-guide/127.0.0.1_8000_keuangan_verifikasi.png)
*Halaman verifikasi pembayaran dengan button aksi*

#### Langkah-langkah:
1. Login sebagai Keuangan
2. Buka menu **"Verifikasi Bayar"**
3. Lihat daftar pembayaran yang masuk

#### Proses Verifikasi:
1. Klik **"Lihat"** untuk melihat bukti transfer
2. Cocokkan dengan data:
   - Nominal transfer
   - Tanggal transfer
   - Nama pengirim
   - Nomor rekening
3. Keputusan:
   - **Terima**: Klik tombol **"Terima"** (hijau)
   - **Tolak**: Klik tombol **"Tolak"** (merah) dan beri alasan

#### Status Pembayaran:
- 🟡 **Menunggu**: Belum diverifikasi
- 🟢 **Terverifikasi**: Pembayaran diterima
- 🔴 **Ditolak**: Pembayaran tidak valid

### 2. Laporan Keuangan

#### Membuat Laporan:
1. Buka menu **"Laporan"**
2. Pilih periode laporan
3. Klik **"Generate"**
4. Download laporan

#### Isi Laporan:
- Total pemasukan
- Jumlah pembayaran terverifikasi
- Pembayaran pending
- Pembayaran ditolak
- Detail per pendaftar

---

## Panduan untuk Kepala Sekolah

### 1. Dashboard Eksekutif

![Dashboard Kepala Sekolah](../public/images/user-guide/127.0.0.1_8000_dashboard_kepsek.png)
*Dashboard eksekutif kepala sekolah dengan KPI lengkap*

#### Informasi yang Ditampilkan:
- **KPI Pendaftaran**: Total pendaftar vs kuota
- **Rasio Verifikasi**: Persentase terverifikasi
- **Total Pemasukan**: Dari pembayaran
- **Pendaftar Hari Ini**: Tren harian

### 2. Monitoring

#### Fitur Monitoring:
1. **Grafik Pendaftaran**: Tren per hari/minggu
2. **Data per Jurusan**: Distribusi pendaftar
3. **Asal Sekolah**: Top 5 sekolah asal
4. **Status Verifikasi**: Progress verifikasi

### 3. Laporan Eksekutif

#### Jenis Laporan:
- Laporan Bulanan
- Laporan per Gelombang
- Laporan Komparasi Tahun
- Laporan Prediksi

---

## FAQ

### Pertanyaan Umum Pendaftar

**Q: Lupa password, bagaimana cara reset?**
A: Klik "Lupa Password" di halaman login, masukkan email, dan ikuti instruksi yang dikirim ke email.

**Q: Berkas yang diupload salah, bisa diganti?**
A: Ya, selama status masih DRAFT atau belum diverifikasi, Anda bisa upload ulang.

**Q: Berapa lama proses verifikasi?**
A: Verifikasi administrasi: 1-3 hari kerja. Verifikasi pembayaran: 1x24 jam.

**Q: Biaya pendaftaran berapa?**
A: Lihat di halaman pembayaran atau hubungi panitia. Biaya bervariasi per gelombang.

**Q: Bisa daftar lebih dari 1 jurusan?**
A: Tidak, setiap pendaftar hanya bisa memilih 1 jurusan.

### Pertanyaan Umum Admin

**Q: Bagaimana cara backup data?**
A: Gunakan fitur export di menu Laporan atau backup database secara manual.

**Q: Bisa import data pendaftar dari Excel?**
A: Fitur import tersedia di menu Data Pendaftar > Import.

**Q: Bagaimana cara menutup pendaftaran?**
A: Nonaktifkan gelombang yang sedang berjalan di menu Gelombang.

---

## Troubleshooting

### Masalah Login

**Problem**: Tidak bisa login
**Solusi**:
1. Pastikan email dan password benar
2. Cek caps lock
3. Clear cache browser
4. Coba browser lain
5. Reset password jika perlu

### Masalah Upload

**Problem**: Upload berkas gagal
**Solusi**:
1. Cek ukuran file (max 2MB)
2. Cek format file (JPG/PNG/PDF)
3. Cek koneksi internet
4. Compress file jika terlalu besar
5. Coba browser lain

### Masalah Pembayaran

**Problem**: Bukti transfer tidak muncul
**Solusi**:
1. Refresh halaman
2. Cek apakah upload berhasil
3. Upload ulang jika perlu
4. Hubungi bagian keuangan

### Masalah Verifikasi

**Problem**: Status tidak berubah setelah verifikasi
**Solusi**:
1. Refresh halaman
2. Logout dan login kembali
3. Cek koneksi internet
4. Hubungi admin sistem

---

## Lokasi Penyimpanan File

### 📁 Struktur Folder Upload

Semua file yang diupload oleh pendaftar (foto, berkas, bukti pembayaran) disimpan di server dengan struktur folder sebagai berikut:

```
ppdb/
├── public/
│   ├── storage/
│   │   ├── berkas/              # Folder utama berkas pendaftar
│   │   │   ├── foto/            # Foto 3x4 pendaftar
│   │   │   │   └── {user_id}_foto.jpg
│   │   │   ├── kk/              # Kartu Keluarga
│   │   │   │   └── {user_id}_kk.pdf
│   │   │   ├── akta/            # Akta Kelahiran
│   │   │   │   └── {user_id}_akta.pdf
│   │   │   ├── ijazah/          # Ijazah SMP
│   │   │   │   └── {user_id}_ijazah.pdf
│   │   │   └── rapor/           # Rapor Semester 1-5
│   │   │       └── {user_id}_rapor.pdf
│   │   │
│   │   └── pembayaran/          # Bukti pembayaran
│   │       └── {user_id}_bukti_bayar.jpg
│
├── storage/
│   ├── app/
│   │   ├── public/              # Symbolic link ke public/storage
│   │   │   ├── berkas/
│   │   │   └── pembayaran/
│   │   │
│   │   └── private/             # File private (backup, export)
│   │       ├── exports/         # File export laporan
│   │       └── backups/         # Backup database
│   │
│   └── logs/                    # Log sistem
│       └── laravel.log
```

### 🔐 Keamanan File

#### Akses File:
1. **Public Storage** (`public/storage/`):
   - Dapat diakses melalui URL
   - Contoh: `http://127.0.0.1:8000/storage/berkas/foto/123_foto.jpg`
   - Dilindungi dengan middleware authentication
   - Hanya user yang bersangkutan dan staff yang bisa akses

2. **Private Storage** (`storage/app/private/`):
   - Tidak dapat diakses langsung via URL
   - Hanya bisa diakses melalui controller
   - Untuk file sensitif seperti backup dan export

#### Proteksi:
- ✅ File dienkripsi dengan nama unik
- ✅ Validasi tipe file saat upload
- ✅ Scan virus otomatis (jika tersedia)
- ✅ Backup berkala ke cloud storage
- ✅ Access control berdasarkan role

### 💾 Cara Mengakses File (Developer/Admin)

#### Via Laravel Storage:
```php
// Mengambil file berkas
$foto = Storage::disk('public')->get('berkas/foto/123_foto.jpg');

// Mengambil URL file
$url = Storage::url('berkas/foto/123_foto.jpg');

// Download file
return Storage::download('berkas/foto/123_foto.jpg');
```

#### Via File Manager:
1. Buka folder project: `c:\laragon\www\ppdb`
2. Masuk ke: `public\storage\berkas`
3. Pilih kategori file (foto/kk/akta/ijazah/rapor)
4. File tersimpan dengan format: `{user_id}_{jenis}.{ext}`

### 📊 Informasi Penyimpanan

#### Kapasitas:
- **Max file size**: 2MB per file
- **Total storage**: Tergantung server (default: unlimited)
- **Recommended**: Minimal 10GB untuk 1000 pendaftar

#### Format File:
- **Foto**: JPG, PNG (max 2MB)
- **Dokumen**: PDF, JPG, PNG (max 2MB)
- **Bukti Bayar**: JPG, PNG (max 2MB)

#### Naming Convention:
```
{user_id}_{jenis_berkas}.{extension}

Contoh:
- 123_foto.jpg
- 123_kk.pdf
- 123_akta.pdf
- 123_ijazah.pdf
- 123_rapor.pdf
- 123_bukti_bayar.jpg
```

### 🗑️ Pengelolaan File

#### Backup Otomatis:
- Backup harian ke: `storage/app/private/backups/`
- Format: `backup_YYYYMMDD.zip`
- Retention: 30 hari
- Lokasi cloud: Google Drive / AWS S3 (opsional)

#### Cleanup:
```bash
# Hapus file pendaftar yang ditolak (>30 hari)
php artisan ppdb:cleanup-rejected

# Hapus file temporary
php artisan ppdb:cleanup-temp

# Compress old files
php artisan ppdb:compress-old-files
```

#### Restore File:
1. Buka folder backup: `storage/app/private/backups/`
2. Extract file backup yang diinginkan
3. Copy ke folder `public/storage/berkas/`
4. Atau gunakan command:
   ```bash
   php artisan ppdb:restore-backup backup_20251120.zip
   ```

### 📸 Screenshot Lokasi File

**Lokasi di Windows Explorer:**
```
C:\laragon\www\ppdb\public\storage\berkas\
├── foto\
├── kk\
├── akta\
├── ijazah\
└── rapor\

C:\laragon\www\ppdb\public\storage\pembayaran\
└── bukti_transfer\
```

**Lokasi di Linux/Mac:**
```
/var/www/ppdb/public/storage/berkas/
├── foto/
├── kk/
├── akta/
├── ijazah/
└── rapor/

/var/www/ppdb/public/storage/pembayaran/
└── bukti_transfer/
```

### ⚙️ Konfigurasi Storage

**File**: `config/filesystems.php`
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
    
    'berkas' => [
        'driver' => 'local',
        'root' => storage_path('app/public/berkas'),
    ],
    
    'pembayaran' => [
        'driver' => 'local',
        'root' => storage_path('app/public/pembayaran'),
    ],
],
```

### 🔗 Symbolic Link

Untuk membuat symbolic link dari `storage/app/public` ke `public/storage`:

```bash
# Windows (Run as Administrator)
php artisan storage:link

# Linux/Mac
php artisan storage:link
```

Jika gagal, buat manual:
```bash
# Windows
mklink /D "C:\laragon\www\ppdb\public\storage" "C:\laragon\www\ppdb\storage\app\public"

# Linux/Mac
ln -s /var/www/ppdb/storage/app/public /var/www/ppdb/public/storage
```

### 📝 Catatan Penting

1. **Jangan hapus folder storage** - Semua file pendaftar ada di sini
2. **Backup rutin** - Minimal 1x seminggu
3. **Monitor disk space** - Pastikan tidak penuh
4. **Set permission** - Folder storage harus writable (755 atau 775)
5. **Gunakan .gitignore** - Jangan commit file upload ke git

---

## Kontak Dukungan

### Bantuan Teknis
- **Email**: support@ppdb.com
- **WhatsApp**: +62 812-3456-7890
- **Telegram**: @ppdb_support

### Jam Operasional
- Senin - Jumat: 08.00 - 16.00 WIB
- Sabtu: 08.00 - 12.00 WIB
- Minggu & Libur: Tutup

### Informasi Lebih Lanjut
- **Website**: https://ppdb.smkbaknus.sch.id
- **Instagram**: @ppdb_smkbaknus
- **Facebook**: PPDB SMK BAKNUS 666

---

**Terakhir diupdate**: 20 November 2025
**Versi**: 1.0.0

---

© 2025 SMK BAKNUS 666. All rights reserved.
