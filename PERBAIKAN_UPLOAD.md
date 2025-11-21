# Perbaikan Upload Data dan Berkas Pendaftar

## Masalah yang Diperbaiki
Data dan berkas yang sudah diupload melalui auto-save tidak tersimpan ke database saat submit, malah ter-reset.

## Solusi yang Diterapkan

### 1. Form Pendaftaran (form.blade.php)
- **Validasi File Dinamis**: File upload tidak lagi required jika sudah ada berkas yang terupload sebelumnya
- **Indikator Visual**: Menampilkan tanda centang hijau untuk file yang sudah diupload
- **Validasi JavaScript**: Memperbaiki fungsi validateStep4() untuk mengecek file yang sudah ada

### 2. Controller (PendaftarController.php)
- **Validasi Dinamis**: Rules validasi disesuaikan berdasarkan keberadaan berkas
- **Preserve Data**: Data yang sudah ada tidak akan di-overwrite dengan nilai kosong
- **File Management**: File lama akan dihapus saat upload file baru

### 3. Direktori Upload
- Membuat direktori `public/uploads/berkas/` untuk menyimpan berkas pendaftar
- Membuat direktori `public/uploads/pembayaran/` untuk menyimpan bukti pembayaran

## Cara Kerja

1. **Auto-Save**: Saat pendaftar mengisi form, data otomatis tersimpan ke database
2. **Upload Berkas**: File yang diupload langsung tersimpan melalui auto-save
3. **Submit**: Saat submit, sistem hanya memvalidasi data wajib dan mengubah status menjadi SUBMITTED
4. **Preserve Data**: Data dan file yang sudah ada tidak akan hilang

## Testing

Untuk menguji perbaikan:
1. Login sebagai pendaftar
2. Isi form step by step
3. Upload berkas di step 4
4. Klik submit
5. Verifikasi data tersimpan di database dan file ada di folder uploads

## Catatan Penting

- Pastikan folder `public/uploads/berkas/` dan `public/uploads/pembayaran/` memiliki permission write
- File yang diupload akan di-overwrite jika upload file baru dengan jenis yang sama
- LocalStorage digunakan untuk backup data form (non-file)
