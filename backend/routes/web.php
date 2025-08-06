<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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
    Route::middleware('role:user')->group(function () {
        Route::get('/user/pemilihan', [UserController::class, 'pemilihan'])->name('user.pemilihan'); // Halaman Pemilihan untuk User
        Route::post('/user/pemilihan', [UserController::class, 'storePemilihan'])->name('user.storePemilihan'); // Menyimpan Pemilihan User
        Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout'); // Logout User
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        // Route Resource untuk Kandidat
        Route::resource('admin/kandidat', AdminController::class)
            ->except(['create', 'store']); // Hanya membutuhkan GET, UPDATE, EDIT, DELETE
        
        // Route Resource untuk Masyarakat
        Route::resource('admin/masyarakat', AdminController::class)
            ->except(['create', 'store']); // Hanya membutuhkan GET, UPDATE, EDIT, DELETE
        
        // Route Resource untuk Pemilihan
        Route::resource('user/pemilihan', UserController::class)
            ->except(['create', 'store']); // Hanya membutuhkan GET, UPDATE, EDIT, DELETE

        // Admin - Kelola Data Kandidat
        Route::get('/admin/kelola-data-kandidat', [AdminController::class, 'kelolaDataKandidat'])->name('admin.dataKandidat'); // Kelola Data Kandidat
        Route::get('/admin/kelola-data-masyarakat', [AdminController::class, 'kelolaDataMasyarakat'])->name('admin.dataMasyarakat'); // Kelola Data Masyarakat
        Route::get('/admin/generator-credential', [AdminController::class, 'credentialGenerator'])->name('admin.credentialGenerator'); // Generator Credential
        Route::get('/admin/lihat-hasil', [AdminController::class, 'lihatHasil'])->name('admin.lihatHasil'); // Lihat Hasil

        // Admin - Edit dan Hapus Data Kandidat dan Masyarakat
        Route::get('/admin/edit-kandidat/{id}', [AdminController::class, 'editKandidat'])->name('admin.editKandidat'); // Edit Data Kandidat
        Route::post('/admin/update-kandidat/{id}', [AdminController::class, 'updateKandidat'])->name('admin.updateKandidat'); // Update Data Kandidat
        Route::delete('/admin/delete-kandidat/{id}', [AdminController::class, 'deleteKandidat'])->name('admin.deleteKandidat'); // Hapus Data Kandidat

        Route::get('/admin/edit-masyarakat/{id}', [AdminController::class, 'editMasyarakat'])->name('admin.editMasyarakat'); // Edit Data Masyarakat
        Route::post('/admin/update-masyarakat/{id}', [AdminController::class, 'updateMasyarakat'])->name('admin.updateMasyarakat'); // Update Data Masyarakat
        Route::delete('/admin/delete-masyarakat/{id}', [AdminController::class, 'deleteMasyarakat'])->name('admin.deleteMasyarakat'); // Hapus Data Masyarakat
    });
});

require __DIR__.'/auth.php'; // Route untuk Autentikasi
