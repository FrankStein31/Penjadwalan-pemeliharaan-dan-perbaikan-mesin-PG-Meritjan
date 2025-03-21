<?php

use Illuminate\Support\Facades\Route;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\{
    MesinController,
    AuthController,
    DashboardController,
    UserController,
    JadwalPemeliharaanController,
    RepairAssignmentController,
    RiwayatLaporanController,
    TeknisiMesinController,
    SparePartController,
    ScreeningController,
    StationController
};
use Illuminate\Routing\RouteUrlGenerator;

Route::middleware(['auth', 'role:Administrator'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::middleware(['auth', 'role:Teknisi'])->group(function () {
    Route::get('/teknisi/dashboard', [DashboardController::class, 'index']) ->name('teknisi.dashboard');
});

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

Route::get('/admin/getTeknisiByMesin/{mesin_id}', [JadwalPemeliharaanController::class, 'getTeknisiByMesin']);

// Teknisi Mesin Routes
Route::get('teknisi-mesin', [TeknisiMesinController::class, 'index'])->name('teknisi_mesin.index');
Route::get('teknisi-mesin/tambah', [TeknisiMesinController::class, 'create'])->name('teknisi_mesin.create');
Route::post('teknisi-mesin/tambah', [TeknisiMesinController::class, 'store'])->name('teknisi_mesin.store');
Route::get('teknisi-mesin/edit/{id}', [TeknisiMesinController::class, 'edit'])->name('teknisi_mesin.edit');
Route::put('teknisi-mesin/edit/{id}', [TeknisiMesinController::class, 'update'])->name('teknisi_mesin.update');
Route::delete('teknisi-mesin/hapus/{id}', [TeknisiMesinController::class, 'destroy'])->name('teknisi_mesin.destroy');
Route::get('mesin/{id}', [MesinController::class, 'show'])->name('mesin.show');
Route::post('mesin/{id}/add-spare-part', [MesinController::class, 'addSparePart'])->name('mesin.add_spare_part');
Route::put('mesin/{mesin_id}/update-spare-part/{spare_part_id}', [MesinController::class, 'updateSparePart'])->name('mesin.update_spare_part');
Route::delete('mesin/{mesin_id}/remove-spare-part/{spare_part_id}', [MesinController::class, 'removeSparePart'])->name('mesin.remove_spare_part');



// Mesin Routes
Route::get('/mesin', [MesinController::class, 'index'])->name('mesin.index');

Route::get('/create', [MesinController::class, 'create'])->name('mesin.create');
Route::post('/mesin', [MesinController::class, 'store'])->name('mesin.store');Route::get('mesin/edit/{id}', [App\Http\Controllers\MesinController::class, 'edit'])->name('mesin.edit');
Route::put('mesin/edit/{id}', [App\Http\Controllers\MesinController::class, 'update'])->name('mesin.update');
Route::delete('mesin/hapus/{id}', [App\Http\Controllers\MesinController::class, 'destroy'])->name('mesin.destroy');

// Spare Part Routes
Route::get('spare_part', [SparePartController::class, 'index'])->name('spare_part');
Route::get('spare_part/tambah', [SparePartController::class, 'create'])->name('admin.spare_part.create');
Route::post('spare_part/tambah', [SparePartController::class, 'store'])->name('admin.spare_part.store');
Route::get('spare_part/edit/{id}', [SparePartController::class, 'edit'])->name('spare_part.edit');
Route::put('spare_part/edit/{id}', [SparePartController::class, 'update'])->name('spare_part.update');
Route::delete('spare_part/hapus/{id}', [SparePartController::class, 'destroy'])->name('spare_part.destroy');

Route::resource('screenings', ScreeningController::class);

Route::get('screenings-teknisi', [ScreeningController::class, 'indexteknisi'])->name('screenings.indexteknisi');
Route::get('screenings-teknisi/edit/{screening}',[ScreeningController::class, 'editteknisi'])->name('screenings.editteknisi');
Route::put('screenings-teknisi/edit/{screening}',[ScreeningController::class, 'updateteknisi'])->name('screenings.updateteknisi');
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

    //Jadwal Pemeliharaan Routes
    Route::prefix('jadwal-pemeliharaan')->group(function () {
        Route::get('/', [JadwalPemeliharaanController::class, 'index'])->name('admin.jadwal.index');
        Route::get('/jadwal-teknisi', [JadwalPemeliharaanController::class, 'indexteknisi'])->name('admin.jadwal.indexteknisi'); // Menampilkan semua jadwal
        Route::get('/tambah', [JadwalPemeliharaanController::class, 'create'])->name('admin.jadwal.create');
        Route::post('/', [JadwalPemeliharaanController::class, 'store'])->name('admin.jadwal.store'); // Menambah jadwal baru
        // Route::get('/{id}', [JadwalPemeliharaanController::class, 'show'])->name('admin.jadwal.show'); // Detail jadwal
        Route::put('/update/{id}', [JadwalPemeliharaanController::class, 'update'])->name('admin.jadwal.update');
        Route::put('/admin/jadwal/{id}/selesai', [JadwalPemeliharaanController::class, 'markAsSelesai'])
    ->name('admin.jadwal.selesai');
    Route::put('/admin/jadwal/{id}/dibatalkan', [JadwalPemeliharaanController::class, 'markAsDibatakan'])
    ->name('admin.jadwal.dibatalkan');
        Route::get('/edit/{id}', [JadwalPemeliharaanController::class, 'edit'])->name('admin.jadwal.edit');
        Route::delete('/hapus/{id}', [JadwalPemeliharaanController::class, 'destroy'])->name('admin.jadwal.delete'); // Hapus jadwal
        Route::get('/get-teknisi-by-station', [JadwalPemeliharaanController::class, 'getTeknisiByMesin'])->name('get.teknisi.by.station');

    });

    Route::get('/repair', [RepairAssignmentController::class, 'index'])->name('admin.repair.index');
    Route::get('/repair/assign', [RepairAssignmentController::class, 'create'])->name('repair.assign');
    Route::post('/repair/assign', [RepairAssignmentController::class, 'store'])->name('repair.assign.store');
    Route::post('/repair/update-status/{id}', [RepairAssignmentController::class, 'updateStatus'])->name('repair.update.status');

    //R
    Route::get('/laporan', [RiwayatLaporanController::class, 'index'])->name('admin.riwayat.index');
    Route::get('/laporan-teknisi', [RiwayatLaporanController::class, 'indexteknisi'])->name('admin.riwayat.indexteknisi');

    //Cetak PDF
    Route::get('/admin/riwayat/pdf', [RiwayatLaporanController::class, 'exportPDF'])->name('admin.riwayat.pdf');
});

Route::resource('stations', StationController::class);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('stations', StationController::class);
});

