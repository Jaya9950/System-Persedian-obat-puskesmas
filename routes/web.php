<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login')->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ROUTE USERS
    Route::resource('users', UserController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::post('/users/ganti-password', [UserController::class, 'gantiPassword'])->name('users.ganti-password');
    Route::post('/users/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // GET DATA
    Route::prefix('get-data')->as('get-data.')->group(function () {
        Route::get('/obat', [ProductController::class, 'getData'])->name('obat');
        Route::get('/cek-stok-awal-obat', [ProductController::class, 'cekStok_Awal'])->name('cek-stok-awal');
    });

    // DATA OBAT
    Route::prefix('data-obat')->as('data-obat.')->group(function () {
        Route::prefix('kategori')->as('kategori.')->controller(KategoriController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{id}/destroy', 'destroy')->name('destroy');
        });

        Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{id}/destroy', 'destroy')->name('destroy');
        });
    });

    // PENERIMAAN BARANG
    Route::prefix('penerimaan-barang')->as('penerimaan-barang.')->controller(PenerimaanBarangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    // PENGELUARAN BARANG
    Route::prefix('pengeluaran-barang')->as('pengeluaran-barang.')->controller(PengeluaranBarangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    // LAPORAN
    Route::prefix('laporan')->as('laporan.')->group(function () {
        Route::prefix('penerimaan-barang')->as('penerimaan-barang.')->controller(PenerimaanBarangController::class)->group(function () {
            Route::get('/laporan', 'laporan')->name('laporan');
            Route::get('/laporan/{nomor_penerimaan}/detail', 'detailLaporan')->name('detail-laporan');
            Route::get('/laporan/{nomor_penerimaan}/detail/export/pdf', 'exportPDF')->name('detail.export.pdf');
            Route::get('/laporan/{nomor_penerimaan}/detail/export/excel', 'exportExcel')->name('detail.export.excel');
        });

        Route::prefix('pengeluaran-barang')->as('pengeluaran-barang.')->controller(PengeluaranBarangController::class)->group(function () {
            Route::get('/laporan', 'laporan')->name('laporan');
            Route::get('/laporan/{nomor_pengeluaran}/detail', 'detailLaporan')->name('detail-laporan');
            Route::get('/export/excel', 'exportExcel')->name('export.excel');
            Route::get('/export/pdf', 'exportPDF')->name('export.pdf');
            Route::get('/laporan/{nomor_pengeluaran}/detail/export/pdf', 'exportPDF')->name('detail.export.pdf');
            Route::get('/laporan/{nomor_pengeluaran}/detail/export/excel', 'exportExcel')->name('detail.export.excel');
            Route::get('laporan/pengeluaran-barang', 'laporan')->name('laporan.pengeluaran-barang.laporan');
            Route::get('laporan/pengeluaran-barang/{nomor}', 'detailLaporan')->name('laporan.pengeluaran-barang.detail-laporan');
        });
    });
});