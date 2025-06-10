<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\BarangController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\LaporanController;
use App\Http\Controllers\admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\admin\UserController;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('user', UserController::class);
    
    Route::get('/laporan/barang', [LaporanController::class, 'index'])->name('laporan.barang');
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');

    Route::get('/admin/laporan/barang/export', [LaporanController::class, 'exportBarang'])->name('laporan.barang.export');
    Route::get('/admin/laporan/peminjaman/export', [LaporanController::class, 'exportPeminjaman'])->name('laporan.peminjaman.export');
    Route::get('/admin/laporan/pengembalian/export', [LaporanController::class, 'exportPengembalian'])->name('laporan.pengembalian.export');

    Route::get('/admin/laporan/barang/pdf', [LaporanController::class, 'exportBarangPdf'])->name('laporan.barang.pdf');
    Route::get('/admin/laporan/peminjaman/pdf', [LaporanController::class, 'exportPeminjamanPdf'])->name('laporan.peminjaman.pdf');
    Route::get('/admin/laporan/pengembalian/pdf', [LaporanController::class, 'exportPengembalianPdf'])->name('laporan.pengembalian.pdf');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

    // Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian/{id}/approve', [PengembalianController::class, 'approve'])->name('pengembalian.approve');
    Route::post('pengembalian/{id}/reject', [PengembalianController::class, 'reject'])->name('pengembalian.reject');
    Route::get('pengembalian/{id}/mark-damaged', [PengembalianController::class, 'markDamaged'])->name('pengembalian.markDamaged');
    Route::put('pengembalian/{id}/update-damaged', [PengembalianController::class, 'updateDamaged'])->name('pengembalian.updateDamaged');

});

Route::get('/user', function () {
    return ('user');
})->middleware('auth', 'role:user');







