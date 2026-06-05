<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\OperationalController;

Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::get('/users',       [MasterDataController::class, 'users'])->name('users');
        Route::get('/doctors',     [MasterDataController::class, 'doctors'])->name('doctors');
        Route::get('/patients',    [MasterDataController::class, 'patients'])->name('patients');
        Route::get('/polyclinics', [MasterDataController::class, 'polyclinics'])->name('polyclinics');
    });

    Route::prefix('operational')->name('operational.')->group(function () {
        Route::get('/queue',   [OperationalController::class, 'queue'])->name('queue');
        Route::get('/history', [OperationalController::class, 'history'])->name('history');
    });
});