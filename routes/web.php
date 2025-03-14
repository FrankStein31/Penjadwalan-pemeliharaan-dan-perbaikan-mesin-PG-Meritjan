<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MesinController,
    AuthController,
    DashboardController,
    UserController,
    JadwalPemeliharaanController
};
use Illuminate\Routing\RouteUrlGenerator;

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSimpan')->name('register.simpan');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAksi')->name('login.aksi');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/', function () {
    return view('Auth.login');
});

// Mesin Routes
Route::get('mesin', [App\Http\Controllers\MesinController::class, 'index'])->name('mesin');
Route::get('mesin/tambah', [App\Http\Controllers\MesinController::class, 'create'])->name('admin.mesin.create');
Route::post('mesin/tambah', [App\Http\Controllers\MesinController::class, 'store'])->name('admin.mesin.store');
Route::get('mesin/edit/{id}', [App\Http\Controllers\MesinController::class, 'edit'])->name('mesin.edit');
Route::put('mesin/edit/{id}', [App\Http\Controllers\MesinController::class, 'update'])->name('mesin.update');
Route::delete('mesin/hapus/{id}', [App\Http\Controllers\MesinController::class, 'destroy'])->name('mesin.destroy');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');

    // User Routes
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('', 'index')->name('users');
        Route::get('tambah', 'tambah')->name('users.tambah');
        Route::post('tambah', 'simpan')->name('users.tambah.simpan');
        Route::get('edit/{id}', 'edit')->name('users.edit');
        Route::put('edit/{id}', 'update')->name('users.tambah.update');
        Route::get('hapus/{id}', 'hapus')->name('users.hapus');
    });

    Route::prefix('jadwal-pemeliharaan')->group(function () {
        Route::get('/', [JadwalPemeliharaanController::class, 'index'])->name('admin.jadwal.index'); // Menampilkan semua jadwal
        Route::get('/tambah', [JadwalPemeliharaanController::class, 'create'])->name('admin.jadwal.create');
        Route::post('/', [JadwalPemeliharaanController::class, 'store'])->name('admin.jadwal.store'); // Menambah jadwal baru
        // Route::get('/{id}', [JadwalPemeliharaanController::class, 'show'])->name('admin.jadwal.show'); // Detail jadwal
        Route::get('/edit/{id}', [JadwalPemeliharaanController::class, 'edit'])->name('admin.jadwal.edit');
        Route::put('/update/{id}', [JadwalPemeliharaanController::class, 'update'])->name('admin.jadwal.update');
        Route::delete('/hapus/{id}', [JadwalPemeliharaanController::class, 'destroy'])->name('admin.jadwal.delete'); // Hapus jadwal
    });
});


