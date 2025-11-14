<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard']);
    Route::get('/kepsek', [App\Http\Controllers\AdminController::class, 'kepsekDashboard']);
    Route::get('/keuangan', [App\Http\Controllers\AdminController::class, 'keuanganDashboard']);
    Route::get('/verifikator', [App\Http\Controllers\VerifikatorController::class, 'dashboard']);
    Route::get('/pendaftar', [App\Http\Controllers\PendaftarController::class, 'dashboard']);
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/master', [App\Http\Controllers\AdminController::class, 'masterData']);
    Route::get('/monitoring', [App\Http\Controllers\AdminController::class, 'monitoring']);
    Route::get('/peta', [App\Http\Controllers\AdminController::class, 'peta']);
    Route::get('/akun', [App\Http\Controllers\AdminController::class, 'akunManagement']);
    
    // API Routes for real-time data
    Route::prefix('api')->group(function () {
        Route::get('/dashboard-stats', [App\Http\Controllers\AdminController::class, 'getDashboardStats']);
        Route::get('/daily-chart', [App\Http\Controllers\AdminController::class, 'getDailyChart']);
        Route::get('/jurusan-stats', [App\Http\Controllers\AdminController::class, 'getJurusanStats']);
        Route::get('/sebaran-data', [App\Http\Controllers\AdminController::class, 'getSebaranData']);
    });
});

// Verifikator Routes
Route::middleware(['auth'])->prefix('verifikator')->group(function () {
    Route::get('/verifikasi', [App\Http\Controllers\VerifikatorController::class, 'verifikasi']);
    Route::get('/detail/{id}', [App\Http\Controllers\VerifikatorController::class, 'detail']);
    Route::post('/berkas/{id}', [App\Http\Controllers\VerifikatorController::class, 'updateBerkasStatus']);
    Route::post('/data/{id}', [App\Http\Controllers\VerifikatorController::class, 'updateDataStatus']);
});

// Keuangan Routes
Route::middleware(['auth'])->prefix('keuangan')->group(function () {
    Route::get('/verifikasi', [App\Http\Controllers\KeuanganController::class, 'verifikasi']);
    Route::post('/payment/{id}', [App\Http\Controllers\KeuanganController::class, 'updatePaymentStatus']);
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
    Route::post('/store', [App\Http\Controllers\PendaftarController::class, 'store']);
    Route::get('/berkas', [App\Http\Controllers\PendaftarController::class, 'berkas']);
    Route::get('/pembayaran', [App\Http\Controllers\PendaftarController::class, 'pembayaran']);
    Route::post('/pembayaran', [App\Http\Controllers\PendaftarController::class, 'storePembayaran']);
    Route::get('/status', [App\Http\Controllers\PendaftarController::class, 'status']);
    Route::post('/auto-save', [App\Http\Controllers\PendaftarController::class, 'autoSave']);
});

// Continue Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Jurusan routes
    Route::get('/jurusan/create', [App\Http\Controllers\AdminController::class, 'createJurusan']);
    Route::post('/jurusan', [App\Http\Controllers\AdminController::class, 'storeJurusan']);
    Route::get('/jurusan/{id}/edit', [App\Http\Controllers\AdminController::class, 'editJurusan']);
    Route::put('/jurusan/{id}', [App\Http\Controllers\AdminController::class, 'updateJurusan']);
    Route::delete('/jurusan/{id}', [App\Http\Controllers\AdminController::class, 'deleteJurusan']);
    
    // Gelombang routes
    Route::get('/gelombang/create', [App\Http\Controllers\AdminController::class, 'createGelombang']);
    Route::post('/gelombang', [App\Http\Controllers\AdminController::class, 'storeGelombang']);
    Route::get('/gelombang/{id}/edit', [App\Http\Controllers\AdminController::class, 'editGelombang']);
    Route::put('/gelombang/{id}', [App\Http\Controllers\AdminController::class, 'updateGelombang']);
    Route::delete('/gelombang/{id}', [App\Http\Controllers\AdminController::class, 'deleteGelombang']);
    
    // User/Akun routes
    Route::post('/akun', [App\Http\Controllers\AdminController::class, 'storeUser']);
    Route::put('/akun/{id}', [App\Http\Controllers\AdminController::class, 'updateUser']);
    Route::delete('/akun/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser']);
    Route::post('/akun/{id}/reset-password', [App\Http\Controllers\AdminController::class, 'resetPassword']);
    
    // Wilayah routes
    Route::post('/wilayah', [App\Http\Controllers\AdminController::class, 'storeWilayah']);
    Route::put('/wilayah/{id}', [App\Http\Controllers\AdminController::class, 'updateWilayah']);
    Route::delete('/wilayah/{id}', [App\Http\Controllers\AdminController::class, 'deleteWilayah']);
});

// Region API Routes
Route::prefix('api/regions')->group(function () {
    Route::get('/provinces', function() {
        return App\Models\Province::orderBy('name')->get();
    });
    Route::get('/regencies/{province_id}', function($province_id) {
        return App\Models\Regency::where('province_id', $province_id)->orderBy('name')->get();
    });
    Route::get('/districts/{regency_id}', function($regency_id) {
        return App\Models\District::where('regency_id', $regency_id)->orderBy('name')->get();
    });
    Route::get('/villages/{district_id}', function($district_id) {
        return App\Models\Village::where('district_id', $district_id)->orderBy('name')->get();
    });
});

// OTP Routes
Route::get('/otp-login', function() { return view('auth.otp-login'); });
Route::post('/send-otp', [App\Http\Controllers\OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [App\Http\Controllers\OtpController::class, 'verifyOtp']);

require __DIR__.'/auth.php';
