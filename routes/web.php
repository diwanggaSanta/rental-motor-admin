<?php

use App\Http\Controllers\customerController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\motorController;
use App\Http\Controllers\transaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\AuthController;

// Halaman Login
Route::get('/', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rute Admin (Terlindungi)
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index']);
    
    Route::resource('customer', customerController::class);
    Route::resource('kategori', kategoriController::class);
    Route::resource('motor', motorController::class);
    Route::resource('transaksi', transaksiController::class);
    
    // Route Rekap Penjualan
    Route::get('/rekap-penjualan', [App\Http\Controllers\RekapPenjualanController::class, 'index'])->name('rekap-penjualan.index');
    
    // Route untuk cetak invoice
    Route::get('/transaksi/{id}/invoice', [transaksiController::class, 'invoice'])->name('transaksi.invoice');

    // Route untuk mengubah status transaksi menjadi selesai
    Route::patch('/transaksi/{id}/selesai', [transaksiController::class, 'selesai'])->name('transaksi.selesai');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
