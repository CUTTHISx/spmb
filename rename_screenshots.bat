@echo off
cd public\images\user-guide

REM ========================================
REM BAGIAN 1: HALAMAN PUBLIK (01-04)
REM ========================================
ren "127.0.0.1_8000_.png" "01_halaman_utama.png"
ren "127.0.0.1_8000_login.png" "02_halaman_login.png"
ren "127.0.0.1_8000_register.png" "03_halaman_registrasi.png"

REM ========================================
REM BAGIAN 2: DASHBOARD PENDAFTAR (05-12)
REM ========================================
ren "127.0.0.1_8000_dashboard_pendaftar.png" "05_dashboard_pendaftar.png"
ren "127.0.0.1_8000_dashboard_pendaftar (1).png" "06_kartu_progress.png"
ren "127.0.0.1_8000_dashboard_pendaftar (2).png" "07_menu_navigasi.png"
ren "127.0.0.1_8000_dashboard_pendaftar (3).png" "08_status_verifikasi.png"
ren "127.0.0.1_8000_dashboard_pendaftar (4).png" "09_notifikasi_sistem.png"
ren "127.0.0.1_8000_dashboard_pendaftar (5).png" "10_pengumuman.png"
ren "127.0.0.1_8000_dashboard_pendaftar (6).png" "11_bantuan_faq.png"
ren "127.0.0.1_8000_profile.png" "12_profil_pengguna.png"

REM ========================================
REM BAGIAN 3: FORMULIR PENDAFTARAN (13-18)
REM ========================================
ren "127.0.0.1_8000_pendaftaran_formulir.png" "13_form_data_pribadi.png"
ren "127.0.0.1_8000_pendaftaran.png" "14_form_data_orangtua.png"
ren "127.0.0.1_8000_pendaftaran (1).png" "15_form_asal_sekolah.png"
ren "127.0.0.1_8000_pendaftaran (2).png" "16_upload_berkas.png"
ren "127.0.0.1_8000_pendaftaran (3).png" "17_preview_berkas.png"

REM ========================================
REM BAGIAN 4: PEMBAYARAN (19-21)
REM ========================================
ren "127.0.0.1_8000_pendaftaran_pembayaran.png" "19_halaman_pembayaran.png"

REM ========================================
REM BAGIAN 5: DASHBOARD ADMIN (22-27)
REM ========================================
ren "127.0.0.1_8000_dashboard_admin.png" "22_dashboard_admin.png"
ren "127.0.0.1_8000_admin_monitoring.png" "23_monitoring_pendaftar.png"
ren "127.0.0.1_8000_admin_peta.png" "24_peta_sebaran.png"
ren "127.0.0.1_8000_admin_laporan.png" "25_laporan_statistik.png"

REM ========================================
REM BAGIAN 6: MANAJEMEN PENGGUNA (28-30)
REM ========================================
ren "127.0.0.1_8000_admin_akun.png" "28_manajemen_akun.png"

REM ========================================
REM BAGIAN 7: MASTER DATA (31-36)
REM ========================================
ren "127.0.0.1_8000_admin_master.png" "31_master_data.png"
ren "127.0.0.1_8000_admin_master (1).png" "32_data_gelombang.png"
ren "127.0.0.1_8000_admin_master (2).png" "33_data_jurusan.png"
ren "127.0.0.1_8000_admin_master (3).png" "34_tambah_jurusan.png"
ren "127.0.0.1_8000_admin_master (4).png" "35_edit_master_data.png"

REM ========================================
REM BAGIAN 8: KEPUTUSAN PENERIMAAN (37-40)
REM ========================================
ren "127.0.0.1_8000_admin_keputusan.png" "37_halaman_keputusan.png"
ren "127.0.0.1_8000_admin_keputusan (1).png" "38_detail_keputusan.png"
ren "127.0.0.1_8000_admin_keputusan (2).png" "39_hasil_seleksi.png"

REM ========================================
REM BAGIAN 9: DASHBOARD VERIFIKATOR (41-46)
REM ========================================
ren "127.0.0.1_8000_dashboard_verifikator.png" "41_dashboard_verifikator.png"
ren "127.0.0.1_8000_verifikator_verifikasi.png" "42_daftar_pendaftar.png"
ren "127.0.0.1_8000_verifikator_detail_35.png" "43_detail_pendaftar.png"
ren "127.0.0.1_8000_verifikator_detail_35 (1).png" "44_berkas_pendaftar.png"
ren "127.0.0.1_8000_verifikator_detail_35 (2).png" "45_proses_verifikasi.png"

REM ========================================
REM BAGIAN 10: DASHBOARD KEUANGAN (47-51)
REM ========================================
ren "127.0.0.1_8000_dashboard_keuangan.png" "47_dashboard_keuangan.png"
ren "127.0.0.1_8000_keuangan_verifikasi.png" "48_verifikasi_pembayaran.png"
ren "127.0.0.1_8000_keuangan_verifikasi (1).png" "49_detail_pembayaran.png"
ren "127.0.0.1_8000_keuangan_rekap.png" "50_rekap_keuangan.png"

REM ========================================
REM BAGIAN 11: DASHBOARD KEPALA SEKOLAH (52-54)
REM ========================================
ren "127.0.0.1_8000_dashboard_kepsek.png" "52_dashboard_kepsek.png"

echo ========================================
echo Rename screenshot selesai!
echo ========================================
echo Total file yang direname: 39 file
echo ========================================
pause
