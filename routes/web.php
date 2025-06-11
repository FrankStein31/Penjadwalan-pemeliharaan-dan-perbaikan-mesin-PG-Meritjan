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
    StationController,
    LaporanIncidentalController,
    PascaGilingController,
    RequestPartController
};
use Illuminate\Routing\RouteUrlGenerator;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/teknisi/dashboard', [DashboardController::class, 'index'])->name('teknisi.dashboard');
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

Route::prefix('stations')->name('stations.')->middleware(['auth'])->group(function () {
    Route::get('/', [StationController::class, 'index'])->name('index');
    Route::get('/tambah', [StationController::class, 'create'])->name('create');
    Route::post('/', [StationController::class, 'store'])->name('store');
    Route::get('/edit/{station}', [StationController::class, 'edit'])->name('edit');
    Route::put('/{station}', [StationController::class, 'update'])->name('update');
    Route::delete('/{station}', [StationController::class, 'destroy'])->name('destroy');
});

// Mesin Routes
Route::get('/mesin', [MesinController::class, 'index'])->name('mesin.index');

Route::get('/create', [MesinController::class, 'create'])->name('mesin.create');
Route::post('/mesin', [MesinController::class, 'store'])->name('mesin.store');
Route::get('mesin/edit/{id}', [App\Http\Controllers\MesinController::class, 'edit'])->name('mesin.edit');
Route::put('mesin/edit/{id}', [App\Http\Controllers\MesinController::class, 'update'])->name('mesin.update');
Route::delete('mesin/hapus/{id}', [App\Http\Controllers\MesinController::class, 'destroy'])->name('mesin.destroy');

// Laporan Insidental Routes
Route::get('laporan-insidental', [LaporanIncidentalController::class, 'index'])->name('laporan-insidental.index');
Route::get('laporan-insidental/tambah', [LaporanIncidentalController::class, 'create'])->name('laporan-insidental.create');
Route::post('laporan-insidental/store', [LaporanIncidentalController::class, 'store'])->name('laporan-insidental.store');
Route::get('laporan-insidental/edit/{id}', [LaporanIncidentalController::class, 'edit'])->name('laporan-insidental.edit');
Route::put('laporan-insidental/edit/{id}', [LaporanIncidentalController::class, 'update'])->name('laporan-insidental.update');
Route::delete('laporan-insidental/hapus/{id}', [LaporanIncidentalController::class, 'destroy'])->name('laporan-insidental.destroy');
Route::get('laporan-insidental/show/{id}', [LaporanIncidentalController::class, 'show'])->name('laporan-insidental.show');
Route::get('/teknisi/getMesinByStation/{station_id}', [MesinController::class, 'getMesinByStation']);
// Route untuk approve / reject / selesai
Route::put('laporan-insidental/{id}/approve', [LaporanIncidentalController::class, 'approve'])->name('laporan-insidental.approve');
Route::put('laporan-insidental/{id}/reject', [LaporanIncidentalController::class, 'reject'])->name('laporan-insidental.reject');
Route::put('laporan-insidental/{id}/selesai', [LaporanIncidentalController::class, 'selesai'])->name('laporan-insidental.selesai');
Route::patch('/laporan-insidental/{id}/update-status', [LaporanIncidentalController::class, 'updateStatus'])->name('laporan-insidental.updateStatus');

Route::get('/laporan-insidental/{id}/cetak', [LaporanIncidentalController::class, 'cetak'])->name('laporan-insidental.cetak');
Route::get('/laporan-insidental/{id}/export-pdf', [LaporanIncidentalController::class, 'exportPDF'])->name('laporan-insidental.export-pdf');
Route::get('/laporan/export/{id}', [LaporanIncidentalController::class, 'exportPDF'])->name('laporan.exportPDF');

//Pasca Giling Routes
Route::get('pasca-giling', [PascaGilingController::class, 'index'])->name('pasca-giling.index');
Route::get('pasca-giling/create', [PascaGilingController::class, 'create'])->name('pasca-giling.create');
Route::post('pasca-giling', [PascaGilingController::class, 'store'])->name('pasca-giling.store');
Route::get('pasca-giling/{id}/edit', [PascaGilingController::class, 'edit'])->name('pasca-giling.edit');
Route::put('pasca-giling/{id}', [PascaGilingController::class, 'update'])->name('pasca-giling.update');
Route::delete('pasca-giling/{id}', [PascaGilingController::class, 'destroy'])->name('pasca-giling.destroy');
Route::get('pasca-giling/{id}', [PascaGilingController::class, 'show'])->name('pasca-giling.show');

// Spare Part Routes
Route::get('spare_part', [SparePartController::class, 'index'])->name('spare_part');
Route::get('spare_part/tambah', [SparePartController::class, 'create'])->name('admin.spare_part.create');
Route::post('spare_part/tambah', [SparePartController::class, 'store'])->name('admin.spare_part.store');
Route::get('spare_part/edit/{id}', [SparePartController::class, 'edit'])->name('spare_part.edit');
Route::put('spare_part/edit/{id}', [SparePartController::class, 'update'])->name('spare_part.update');
Route::delete('spare_part/hapus/{id}', [SparePartController::class, 'destroy'])->name('spare_part.destroy');

Route::get('/screening/create/{jadwal_id}', [ScreeningController::class, 'create'])->name('screening.create');
Route::post('/screening/store', [ScreeningController::class, 'store'])->name('screening.store');
Route::get('/screening/{jadwal_id}', [ScreeningController::class, 'show'])->name('screening.show');
Route::get('/screening/jawaban/{id}', [ScreeningController::class, 'jawaban'])->name('screening.jawaban');
Route::get('/admin/pertanyaan', [ScreeningController::class, 'index'])->name('pertanyaan.index');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');

    // User Routes
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('', 'index')->name('users');
        Route::get('tambah', 'tambah')->name('users.tambah');
        Route::post('tambah', 'simpan')->name('users.simpan');
        Route::get('edit/{id}', 'edit')->name('users.edit');
        Route::put('edit/{id}', 'update')->name('users.update'); // <- Ini lebih tepat
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

// Tambahkan route baru
Route::get('/admin/getMesinByStation/{station_id}', [JadwalPemeliharaanController::class, 'getMesinByStation']);
Route::get('/admin/getTeknisiByStation/{station_id}', [JadwalPemeliharaanController::class, 'getTeknisiByStation']);

// Route Teknisi
Route::prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/request-part', [RequestPartController::class, 'index'])->name('request-part.index');
    Route::get('/request-part/create', [RequestPartController::class, 'create'])->name('request-part.create');
    Route::post('/request-part', [RequestPartController::class, 'store'])->name('request-part.store');
    Route::put('/teknisi/request-parts/{id}/cancel', [RequestPartController::class, 'cancel'])
        ->name('teknisi.request-parts.cancel');
});

// Route Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/request-part', [RequestPartController::class, 'index'])->name('request-part.index');
    Route::put('/request-part/{id}/approve', [RequestPartController::class, 'approve'])->name('request-part.approve');
    Route::put('/request-part/{id}/reject', [RequestPartController::class, 'reject'])->name('request-part.reject');
});