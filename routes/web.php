<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/admin', [LoginController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/dashboard/siswa', [LoginController::class, 'siswaDashboard'])->name('siswa.dashboard');

    // Routes untuk admin
    Route::prefix('admin')->name('admin.')->middleware('can:admin-only')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengaduan', [AdminController::class, 'pengaduan'])->name('pengaduan.index');
        Route::get('/pengaduan/{pengaduan}', [AdminController::class, 'showPengaduan'])->name('pengaduan.show');
        Route::put('/pengaduan/{pengaduan}/status', [AdminController::class, 'updateStatus'])->name('pengaduan.update-status');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    });

    // Routes untuk pengaduan siswa
    Route::resource('pengaduan', PengaduanController::class)->except(['index', 'create', 'show', 'edit', 'update', 'destroy']);
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
});
