<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PengajuanController as UserPengajuanController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\VerifikasiPublikController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Verifikasi Publik
Route::get('/verifikasi', [VerifikasiPublikController::class, 'index'])->name('verifikasi.index');
Route::post('/verifikasi', [VerifikasiPublikController::class, 'verify'])->name('verifikasi.check');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin & Kepala Desa Routes
|--------------------------------------------------------------------------
*/
// Di dalam group admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,kepala_desa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route resource penduduk untuk admin
    Route::resource('penduduk', \App\Http\Controllers\Admin\PendudukController::class)->middleware('role:admin');

    // Data Penduduk - Admin CRUD
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create')->middleware('role:admin');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store')->middleware('role:admin');
    Route::get('/penduduk/{penduduk}', [PendudukController::class, 'show'])->name('penduduk.show');
    Route::get('/penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit')->middleware('role:admin');
    Route::put('/penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update')->middleware('role:admin');
    Route::delete('/penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy')->middleware('role:admin');
    Route::get('/penduduk-export', [PendudukController::class, 'exportPdf'])->name('penduduk.export')->middleware('role:admin');
    Route::get('/penduduk-search', [PendudukController::class, 'search'])->name('penduduk.search');

    // Alias untuk Kepala Desa
    Route::get('/penduduk-list', [PendudukController::class, 'index'])->name('penduduk.list');
    Route::get('/surat-list', [SuratController::class, 'index'])->name('surat.list');

    // Pengajuan / Persetujuan
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve')->middleware('role:admin');
    Route::post('/pengajuan/{pengajuan}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject')->middleware('role:admin');
    Route::post('/pengajuan/{pengajuan}/process', [PengajuanController::class, 'process'])->name('pengajuan.process')->middleware('role:admin');

    // Kelola Surat
    Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/create', [SuratController::class, 'create'])->name('surat.create')->middleware('role:admin');
    Route::post('/surat', [SuratController::class, 'store'])->name('surat.store')->middleware('role:admin');
    Route::get('/surat/{surat}', [SuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{surat}/edit', [SuratController::class, 'edit'])->name('surat.edit')->middleware('role:admin');
    Route::put('/surat/{surat}', [SuratController::class, 'update'])->name('surat.update')->middleware('role:admin');
    Route::delete('/surat/{surat}', [SuratController::class, 'destroy'])->name('surat.destroy')->middleware('role:admin');
    Route::get('/surat/{surat}/cetak', [SuratController::class, 'cetak'])->name('surat.cetak');

    // History / Audit Log
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('role:admin');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update')->middleware('role:admin');
    Route::post('/settings/backup', [SettingController::class, 'backup'])->name('settings.backup')->middleware('role:admin');

    // Account
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});


/*
|--------------------------------------------------------------------------
| User / Masyarakat Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Pengajuan Surat
    Route::get('/pengajuan', [UserPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [UserPengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [UserPengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{pengajuan}', [UserPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/pengajuan/{pengajuan}/download', [UserPengajuanController::class, 'downloadSurat'])->name('pengajuan.download');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
