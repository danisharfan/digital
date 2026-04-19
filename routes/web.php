<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| AFTER LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/admin', [LoginController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/dashboard/siswa', [LoginController::class, 'siswaDashboard'])->name('siswa.dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('can:admin-only')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | KELOLA PENGADUAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pengaduan', [AdminController::class, 'pengaduan'])
            ->name('pengaduan.index');

        Route::get('/pengaduan/{pengaduan}', [AdminController::class, 'showPengaduan'])
            ->name('pengaduan.show');

        Route::put('/pengaduan/{pengaduan}/status', [AdminController::class, 'updateStatus'])
            ->name('pengaduan.update-status');

        Route::post('/pengaduan/{pengaduan}/feedback', [AdminController::class, 'feedback'])
            ->name('pengaduan.feedback');

        Route::delete('/pengaduan/{pengaduan}', [AdminController::class, 'destroyPengaduan'])
            ->name('pengaduan.destroy');


        /*
        |--------------------------------------------------------------------------
        | KELOLA USERS / SISWA
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users.index');

        Route::get('/users/create', [AdminController::class, 'createUser'])
            ->name('users.create');

        Route::post('/users/store', [AdminController::class, 'storeUser'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminController::class, 'updateUser'])
            ->name('users.update');

        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | SISWA - PENGADUAN
    |--------------------------------------------------------------------------
    */

    Route::get('/pengaduan', [PengaduanController::class, 'index'])
        ->name('pengaduan.index');

    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])
        ->name('pengaduan.create');

    Route::post('/pengaduan', [PengaduanController::class, 'store'])
        ->name('pengaduan.store');

    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])
        ->name('pengaduan.show');

    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])
        ->name('pengaduan.edit');

    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])
        ->name('pengaduan.update');

    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])
        ->name('pengaduan.destroy');
});