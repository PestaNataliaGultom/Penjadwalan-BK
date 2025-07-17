<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController as StudentController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\GuruBKController;
use App\Http\Controllers\HasilKonselingController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PengaturanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman login
        Route::get('/', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/authenticate', [AuthenticationController::class, 'authenticate'])->name('authenticate');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// Semua route di bawah ini butuh autentikasi
        Route::middleware(['auth'])->group(function () {

    // Dashboard umum
        Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('siswa', SiswaController::class);
        Route::resource('guru', GuruController::class);
    });
    Route::prefix('siswa')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('siswa.dashboard');
        Route::get('/jadwal', [StudentController::class, 'jadwal'])->name('siswa.jadwal');
        Route::post('/jadwal', [StudentController::class, 'jadwalPost'])->name('siswa.jadwalPost');
        Route::get('/jadwal/json', [StudentController::class, 'getSchedules'])->name('siswa.jadwal.json');
    });
    /*
    |--------------------------------------------------------------------------
    | Routes Khusus Guru BK
    |--------------------------------------------------------------------------
    */
    Route::prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruBKController::class, 'dashboard'])->name('guru.dashboard');
        // Hasil Konseling
        Route::get('/hasil-konseling', [HasilKonselingController::class, 'index'])->name('guru.hasil-konseling');
        Route::get('/hasil-konseling/create', [HasilKonselingController::class, 'create'])->name('guru.hasil-konseling.create');
        Route::post('/hasil-konseling', [HasilKonselingController::class, 'store'])->name('guru.hasil-konseling.store');
        Route::get('/hasil-konseling/{id}', [HasilKonselingController::class, 'show'])->name('guru.hasil-konseling.show');
        Route::get('/hasil-konseling/{id}/edit', [HasilKonselingController::class, 'edit'])->name('guru.hasil-konseling.edit');
        Route::put('/hasil-konseling/{id}', [HasilKonselingController::class, 'update'])->name('guru.hasil-konseling.update');
        Route::delete('/hasil-konseling/{id}', [HasilKonselingController::class, 'destroy'])->name('guru.hasil-konseling.destroy');


        // Jadwal
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('guru.jadwal');
        Route::get('/jadwal-json', [JadwalController::class, 'getTotalJadwal'])->name('guru.jadwal.json');
        Route::post('/jadwal-approve', [JadwalController::class, 'approve'])->name('guru.approve');
        
    });
});
