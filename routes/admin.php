<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\OperationalController;

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::get('/users',          [MasterDataController::class, 'users'])->name('users');
        Route::post('/users',         [MasterDataController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}',     [MasterDataController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}',  [MasterDataController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/doctors',        [MasterDataController::class, 'doctors'])->name('doctors');
        Route::post('/doctors',       [MasterDataController::class, 'storeDoctor'])->name('doctors.store');
        Route::put('/doctors/{id}',   [MasterDataController::class, 'updateDoctor'])->name('doctors.update');
        Route::delete('/doctors/{id}', [MasterDataController::class, 'destroyDoctor'])->name('doctors.destroy');

        Route::get('/patients',       [MasterDataController::class, 'patients'])->name('patients');
        Route::post('/patients',      [MasterDataController::class, 'storePatient'])->name('patients.store');
        Route::put('/patients/{id}',  [MasterDataController::class, 'updatePatient'])->name('patients.update');
        Route::delete('/patients/{id}', [MasterDataController::class, 'destroyPatient'])->name('patients.destroy');

        Route::get('/polyclinics',     [MasterDataController::class, 'polyclinics'])->name('polyclinics');
        Route::post('/polyclinics',    [MasterDataController::class, 'storePolyclinic'])->name('polyclinics.store');
        Route::put('/polyclinics/{id}', [MasterDataController::class, 'updatePolyclinic'])->name('polyclinics.update');
        Route::delete('/polyclinics/{id}', [MasterDataController::class, 'destroyPolyclinic'])->name('polyclinics.destroy');
    });

    Route::prefix('operational')->name('operational.')->group(function () {
        Route::get('/queue',            [OperationalController::class, 'queue'])->name('queue');
        Route::post('/queue',           [OperationalController::class, 'storeQueue'])->name('queue.store');
        Route::put('/queue/{id}/done',   [OperationalController::class, 'doneQueue'])->name('queue.done');
        Route::delete('/queue/{id}',     [OperationalController::class, 'destroyQueue'])->name('queue.destroy');
        Route::get('/history',          [OperationalController::class, 'history'])->name('history');
    });
});