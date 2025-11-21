<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jurusan = \App\Models\Jurusan::withCount('pendaftar')->get();
    return view('welcome', compact('jurusan'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
    Route::get('/kepsek', [App\Http\Controllers\Admin\AdminController::class, 'kepsekDashboard']);
    Route::get('/keuangan', [App\Http\Controllers\KeuanganController::class, 'dashboard']);
    Route::get('/verifikator', [App\Http\Controllers\VerifikatorController::class, 'dashboard']);
    Route::get('/pendaftar', [App\Http\Controllers\PendaftarController::class, 'dashboard']);
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/master', [App\Http\Controllers\Admin\AdminController::class, 'masterData']);
    Route::get('/monitoring', [App\Http\Controllers\Admin\MonitoringController::class, 'index']);
    Route::get('/monitoring/{id}', [App\Http\Controllers\Admin\MonitoringController::class, 'detail']);
    Route::get('/peta', [App\Http\Controllers\Admin\PetaController::class, 'index']);
    Route::get('/akun', [App\Http\Controllers\Admin\AkunController::class, 'index']);
    
    // Laporan Routes
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index']);
    Route::get('/export/excel', [App\Http\Controllers\Admin\LaporanController::class, 'exportExcel']);
    Route::get('/export/pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportPDF']);
    
    // Keputusan Routes
    Route::get('/keputusan', [App\Http\Controllers\Admin\KeputusanController::class, 'index'])->name('admin.keputusan.index');
    Route::get('/keputusan/{id}', [App\Http\Controllers\Admin\KeputusanController::class, 'detail'])->name('admin.keputusan.detail');
    Route::post('/keputusan', [App\Http\Controllers\Admin\KeputusanController::class, 'store'])->name('admin.keputusan.store');
    
    // API Routes for real-time data
    Route::prefix('api')->group(function () {
        Route::get('/dashboard-stats', [App\Http\Controllers\Admin\AdminController::class, 'getDashboardStats']);
        Route::get('/daily-chart', [App\Http\Controllers\Admin\AdminController::class, 'getDailyChart']);
        Route::get('/jurusan-stats', [App\Http\Controllers\Admin\AdminController::class, 'getJurusanStats']);
        Route::get('/sebaran-data', [App\Http\Controllers\Admin\PetaController::class, 'getSebaranData']);
    });
    
    // Jurusan routes
    Route::get('/jurusan/create', [App\Http\Controllers\Admin\AdminController::class, 'createJurusan']);
    Route::post('/jurusan', [App\Http\Controllers\Admin\AdminController::class, 'storeJurusan']);
    Route::get('/jurusan/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editJurusan']);
    Route::put('/jurusan/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateJurusan']);
    Route::delete('/jurusan/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteJurusan']);
    
    // Gelombang routes
    Route::get('/gelombang/create', [App\Http\Controllers\Admin\AdminController::class, 'createGelombang']);
    Route::post('/gelombang', [App\Http\Controllers\Admin\AdminController::class, 'storeGelombang']);
    Route::get('/gelombang/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editGelombang']);
    Route::put('/gelombang/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateGelombang']);
    Route::delete('/gelombang/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteGelombang']);
    Route::post('/gelombang/{id}/activate', [App\Http\Controllers\Admin\AdminController::class, 'activateGelombang']);
    Route::post('/gelombang/{id}/deactivate', [App\Http\Controllers\Admin\AdminController::class, 'deactivateGelombang']);
    
    // User/Akun routes
    Route::post('/akun', [App\Http\Controllers\Admin\AkunController::class, 'store']);
    Route::put('/akun/{id}', [App\Http\Controllers\Admin\AkunController::class, 'update']);
    Route::delete('/akun/{id}', [App\Http\Controllers\Admin\AkunController::class, 'destroy']);
    Route::put('/akun/{id}/password', [App\Http\Controllers\Admin\AkunController::class, 'changePassword']);
    
    // Wilayah routes
    Route::post('/wilayah', [App\Http\Controllers\Admin\AdminController::class, 'storeWilayah']);
    Route::put('/wilayah/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateWilayah']);
    Route::delete('/wilayah/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteWilayah']);
});

// Verifikator Routes
Route::middleware(['auth', 'role:verifikator_adm'])->prefix('verifikator')->group(function () {
    Route::get('/verifikasi', [App\Http\Controllers\VerifikatorController::class, 'verifikasi']);
    Route::get('/detail/{id}', [App\Http\Controllers\VerifikatorController::class, 'detail']);
    Route::post('/verifikasi/{id}', [App\Http\Controllers\VerifikatorController::class, 'updateVerifikasi']);
});

// Keuangan Routes
Route::middleware(['auth', 'role:keuangan'])->prefix('keuangan')->group(function () {
    Route::get('/verifikasi', [App\Http\Controllers\KeuanganController::class, 'verifikasi']);
    Route::post('/payment/{id}', [App\Http\Controllers\KeuanganController::class, 'updatePaymentStatus']);
    Route::get('/payment-proof/{id}', [App\Http\Controllers\KeuanganController::class, 'getPaymentProof']);
    Route::get('/rekap', [App\Http\Controllers\Keuangan\RekapController::class, 'index']);
    Route::get('/export/excel', [App\Http\Controllers\Keuangan\RekapController::class, 'exportExcel']);
    Route::get('/export/pdf', [App\Http\Controllers\Keuangan\RekapController::class, 'exportPDF']);
});

// Pendaftar Routes
Route::middleware(['auth'])->prefix('pendaftar')->group(function () {
    Route::get('/form', [App\Http\Controllers\PendaftarController::class, 'form']);
    Route::post('/store', [App\Http\Controllers\PendaftarController::class, 'store']);
    Route::put('/update', [App\Http\Controllers\PendaftarController::class, 'update']);
});

// Pendaftaran Routes (for form views)
Route::middleware(['auth'])->prefix('pendaftaran')->group(function () {
    Route::get('/', [App\Http\Controllers\PendaftarController::class, 'form']);
    Route::get('/test', function() { return view('test-form'); });
    Route::post('/store', [App\Http\Controllers\PendaftarController::class, 'store']);
    Route::post('/submit', [App\Http\Controllers\PendaftarController::class, 'submitPendaftaran']);
    Route::get('/berkas', [App\Http\Controllers\PendaftarController::class, 'berkas']);
    Route::post('/berkas', [App\Http\Controllers\PendaftarController::class, 'storeUpload']);
    Route::get('/pembayaran', [App\Http\Controllers\PendaftarController::class, 'pembayaran']);
    Route::post('/pembayaran', [App\Http\Controllers\PendaftarController::class, 'storePembayaran']);
    Route::get('/status', [App\Http\Controllers\PendaftarController::class, 'status']);
    Route::get('/cetak-kartu', [App\Http\Controllers\PendaftarController::class, 'cetakKartu']);
    Route::get('/formulir', [App\Http\Controllers\PendaftarController::class, 'formulir']);
    Route::post('/auto-save', [App\Http\Controllers\PendaftarController::class, 'autoSave']);
});

// API Routes
Route::post('/api/cek-status', [App\Http\Controllers\Api\StatusController::class, 'cekStatus']);

// OTP Routes
Route::get('/otp-login', function() { return view('auth.otp-login'); });
Route::post('/send-otp', [App\Http\Controllers\OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [App\Http\Controllers\OtpController::class, 'verifyOtp']);
Route::post('/verify-registration-otp', [App\Http\Controllers\OtpController::class, 'verifyRegistrationOtp']);

// Registration OTP Routes
Route::get('/register/otp', [App\Http\Controllers\Auth\RegisteredUserController::class, 'showOtpForm']);
Route::post('/register/complete', [App\Http\Controllers\Auth\RegisteredUserController::class, 'completeRegistration']);

require __DIR__.'/auth.php';