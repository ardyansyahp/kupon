<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ImportController;

Route::get('/', function () {
    return redirect('/tukar/1');
});

Route::get('/admin/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/daftar-tukar', [AdminController::class, 'daftarTukar'])->name('admin.daftar-tukar');
    Route::post('/accept/{id}', [AdminController::class, 'accept'])->name('admin.accept');
    Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    
    Route::get('/import', [ImportController::class, 'index'])->name('admin.import');
    Route::post('/import', [ImportController::class, 'store'])->name('admin.import.store');
    
    Route::get('/karyawan/tambah', [AdminController::class, 'tambahKaryawanForm'])->name('admin.karyawan.tambah');
    Route::post('/karyawan/tambah', [AdminController::class, 'tambahKaryawanStore'])->name('admin.karyawan.store');
    
    Route::get('/karyawan', [AdminController::class, 'listKaryawan'])->name('admin.karyawan.index');
    Route::put('/karyawan/{id}', [AdminController::class, 'updateKaryawan'])->name('admin.karyawan.update');
    Route::delete('/karyawan/delete-all', [AdminController::class, 'deleteAllKaryawan'])->name('admin.karyawan.delete_all');
    Route::delete('/karyawan/{id}', [AdminController::class, 'deleteKaryawan'])->name('admin.karyawan.delete');
});

// Front End Exchange
Route::get('/tukar/{plant}', [KaryawanController::class, 'index'])->name('karyawan.tukar');
Route::get('/api/search/{plant}', [KaryawanController::class, 'search'])->name('karyawan.search');
Route::post('/tukar/proses', [KaryawanController::class, 'prosesTukar'])->name('karyawan.proses');
Route::post('/tukar/proses-baru', [KaryawanController::class, 'prosesTukarBaru'])->name('karyawan.proses-baru');
