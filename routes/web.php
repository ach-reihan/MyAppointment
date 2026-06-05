<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\OperationalController;

use App\Http\Controllers\Doctor\DashboardController as DoctorDashboard;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');

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

Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboard::class, 'index'])->name('dashboard');
});

Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboard::class, 'index'])->name('dashboard');
});