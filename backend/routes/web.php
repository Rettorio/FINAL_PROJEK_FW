<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PemilihanController;
use App\Http\Controllers\PeriodeController;

/*
|--------------------------------------------------------------------------- 
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda. 
| Semua route ini dimuat oleh RouteServiceProvider dan akan 
| ditugaskan ke grup middleware "web".
|
*/

Route::get('/', [GuestController::class, 'home'])->name('home'); // Halaman depan untuk tamu (Guest)

Route::middleware('guest')->group(function () {
    Route::get('/halaman-utama', [GuestController::class, 'landingPage'])->name('landing.page'); // Halaman untuk Tamu
    Route::get('/profil-kandidat', [GuestController::class, 'candidateProfile'])->name('candidate.profile'); // Profil Kandidat untuk Tamu
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit Profil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update Profil
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Hapus Profil

    // User Routes
    Route::middleware('role:voter')->group(function () {
        Route::get('/pemilihan', [UserController::class, 'pemilihan'])->name('user.pemilihan'); // Halaman Pemilihan untuk User
        Route::post('/pemilihan', [UserController::class, 'storePemilihan'])->name('user.storePemilihan'); // Menyimpan Pemilihan User
        Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout'); // Logout User
    });

    // Admin Routes
    Route::middleware('role:Panitia')->prefix('admin')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        // Route Resource for Kandidat (will be /admin/kandidat)
        Route::resource('kandidat', KandidatController::class);

        // Route Resource for Masyarakat (will be /admin/masyarakat)
        Route::resource('masyarakat', MasyarakatController::class);
        // Route hasil pemilihan disini  
        Route::resource('pemilihan', PemilihanController::class);
        // Route periode disini
        Route::resource('periode', PeriodeController::class);
        Route::get('generator-credential', [AdminController::class, 'credentialGenerator'])->name('credentialGenerator.index');
        Route::post('generator-credential', [AdminController::class, 'credentialGeneratorStore'])->name('credentialGenerator.store');
    });
});


Route::get('/live-count', function () {
    return view('live-count');
});

Route::get('/profil-kandidat', function () {
    return view('profil-kandidat');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/login-admin', function () {
    return view('login-admin');
});
