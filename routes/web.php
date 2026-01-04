<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SekolahController;
use App\Http\Controllers\SuperAdmin\AdminController as SuperAdminAdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PelajaranController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\BankSoalController;
use App\Http\Controllers\Guru\UjianController as GuruUjianController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\UjianController as SiswaUjianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Redirect dashboard based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isSuperAdmin()) {
        return redirect()->route('super-admin.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isGuru()) {
        return redirect()->route('guru.dashboard');
    } else {
        return redirect()->route('siswa.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    
    // Sekolah Management
    Route::resource('sekolah', SekolahController::class);
    
    // Admin Management
    Route::resource('admin', SuperAdminAdminController::class);
    
    // Data Management (Super Admin can access all school data)
    // These routes use the same controllers as Admin, but without sekolah_scope middleware
    Route::prefix('data')->name('data.')->group(function () {
        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('kelas', KelasController::class)->except(['show']);
        Route::resource('pelajaran', PelajaranController::class)->except(['show']);
        Route::resource('rombel', RombelController::class);
        
        // Rombel Management
        Route::get('/rombel/{rombel}/manage-siswa', [RombelController::class, 'manageSiswa'])->name('rombel.manage-siswa');
        Route::put('/rombel/{rombel}/update-siswa', [RombelController::class, 'updateSiswa'])->name('rombel.update-siswa');
        Route::get('/rombel/{rombel}/manage-pelajaran', [RombelController::class, 'managePelajaran'])->name('rombel.manage-pelajaran');
        Route::put('/rombel/{rombel}/update-pelajaran', [RombelController::class, 'updatePelajaran'])->name('rombel.update-pelajaran');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin', 'sekolah_scope'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Routes
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class)->except(['show']);
    Route::resource('pelajaran', PelajaranController::class)->except(['show']);
    Route::resource('rombel', RombelController::class);
    
    // Rombel Management
    Route::get('/rombel/{rombel}/manage-siswa', [RombelController::class, 'manageSiswa'])->name('rombel.manage-siswa');
    Route::put('/rombel/{rombel}/update-siswa', [RombelController::class, 'updateSiswa'])->name('rombel.update-siswa');
    Route::get('/rombel/{rombel}/manage-pelajaran', [RombelController::class, 'managePelajaran'])->name('rombel.manage-pelajaran');
    Route::put('/rombel/{rombel}/update-pelajaran', [RombelController::class, 'updatePelajaran'])->name('rombel.update-pelajaran');
});

// Guru Routes
Route::middleware(['auth', 'role:guru', 'sekolah_scope'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    
    // Bank Soal
    // Bank Soal Routes
    Route::get('/bank-soal/download-template', [BankSoalController::class, 'downloadTemplate'])->name('bank-soal.download-template');
    Route::get('/bank-soal/import', [BankSoalController::class, 'showImportForm'])->name('bank-soal.import');
    Route::post('/bank-soal/import', [BankSoalController::class, 'processImport'])->name('bank-soal.process-import');
    Route::get('/bank-soal/create-batch', [BankSoalController::class, 'createBatch'])->name('bank-soal.create-batch');
    Route::post('/bank-soal/store-batch', [BankSoalController::class, 'storeBatch'])->name('bank-soal.store-batch');
    Route::resource('bank-soal', BankSoalController::class);
    
    // Ujian
    Route::resource('ujian', GuruUjianController::class);
    Route::get('/ujian/{ujian}/manage-soal', [GuruUjianController::class, 'manageSoal'])->name('ujian.manage-soal');
    Route::post('/ujian/{ujian}/add-soal', [GuruUjianController::class, 'addSoal'])->name('ujian.add-soal');
    Route::delete('/ujian/{ujian}/remove-soal/{soal}', [GuruUjianController::class, 'removeSoal'])->name('ujian.remove-soal');
    Route::post('/ujian/{ujian}/publish', [GuruUjianController::class, 'publish'])->name('ujian.publish');
    Route::get('/ujian/{ujian}/hasil', [GuruUjianController::class, 'hasil'])->name('ujian.hasil');
    
    // Essay Grading
    Route::get('/ujian/{ujian}/grading', [GuruUjianController::class, 'grading'])->name('ujian.grading');
    Route::post('/ujian/{ujian}/grade-essay/{jawabanSiswa}', [GuruUjianController::class, 'gradeEssay'])->name('ujian.grade-essay');
    
    // Student Result Detail
    Route::get('/ujian/{ujian}/hasil/{hasilUjian}', [GuruUjianController::class, 'hasilDetail'])->name('ujian.hasil-detail');
});

// Siswa Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Ujian
    Route::get('/ujian', [SiswaUjianController::class, 'index'])->name('ujian.index');
    Route::get('/ujian/{ujian}', [SiswaUjianController::class, 'show'])->name('ujian.show');
    Route::post('/ujian/{ujian}/start', [SiswaUjianController::class, 'start'])->name('ujian.start');
    Route::get('/ujian/{ujian}/kerjakan', [SiswaUjianController::class, 'kerjakan'])->name('ujian.kerjakan');
    Route::post('/ujian/{ujian}/save-jawaban', [SiswaUjianController::class, 'saveJawaban'])->name('ujian.save-jawaban');
    Route::post('/ujian/{ujian}/submit', [SiswaUjianController::class, 'submit'])->name('ujian.submit');
    Route::get('/ujian/{ujian}/hasil', [SiswaUjianController::class, 'hasil'])->name('ujian.hasil');
});

require __DIR__.'/auth.php';
