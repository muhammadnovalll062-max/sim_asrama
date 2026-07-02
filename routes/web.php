<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenilaiDashboardController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CalonPenghuniController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProsesPerhitunganController;
use App\Http\Controllers\HasilRankingController;
use App\Http\Controllers\HasilSeleksiController;

Route::get('/', fn() => redirect('/login'));

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// === ADMIN ===
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kamar', KamarController::class);

    // Placeholder — akan diisi bertahap
    Route::resource('penghuni', PenghuniController::class)->except(['create', 'store']);
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/monitoring/kamar',      [MonitoringController::class, 'kamar'])->name('monitoring.kamar');
    Route::get('/monitoring/pembayaran', [MonitoringController::class, 'pembayaran'])->name('monitoring.pembayaran');
    Route::get('/laporan',              [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/penghuni',     [LaporanController::class, 'penghuni'])->name('laporan.penghuni');
    Route::get('/laporan/kamar',        [LaporanController::class, 'kamar'])->name('laporan.kamar');
    Route::get('/laporan/pembayaran',   [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran');
    Route::get('/laporan/tunggakan',    [LaporanController::class, 'tunggakan'])->name('laporan.tunggakan');
    Route::get('/laporan/monitoring',   [LaporanController::class, 'monitoring'])->name('laporan.monitoring');
    Route::get('/hasil-seleksi',                        [HasilSeleksiController::class, 'index'])->name('hasil.seleksi');
    Route::get('/hasil-seleksi/riwayat', [HasilSeleksiController::class, 'riwayat'])->name('hasil.riwayat');
    Route::get('/hasil/{id_calon}/terima',      [HasilSeleksiController::class, 'terimaForm'])->name('hasil.terima.form');
    Route::post('/hasil/{id_calon}/terima',     [HasilSeleksiController::class, 'terima'])->name('hasil.terima');
    Route::post('/hasil/{id_calon}/tolak',      [HasilSeleksiController::class, 'tolak'])->name('hasil.tolak');
});

// === PENILAI ===
Route::middleware(['auth', 'role:penilai'])->group(function () {
    Route::get('/penilai/dashboard', [PenilaiDashboardController::class, 'index'])->name('penilai.dashboard');
    Route::get('/calon/riwayat', [CalonPenghuniController::class, 'riwayat'])->name('calon.riwayat');   
    Route::resource('calon', CalonPenghuniController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::get('/penilaian',                    [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/create/{id_calon?}', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian',                   [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::get('/penilaian/{id_calon}/edit',    [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::put('/penilaian/{id_calon}',         [PenilaianController::class, 'update'])->name('penilaian.update');
    Route::get('/proses-perhitungan',           [ProsesPerhitunganController::class, 'index'])->name('proses.index');
    Route::post('/proses-perhitungan/hitung',   [ProsesPerhitunganController::class, 'hitung'])->name('proses.hitung');
    Route::get('/hasil-ranking',                [HasilRankingController::class, 'index'])->name('ranking.index');
});