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

require __DIR__.'/admin.php';
require __DIR__.'/doctor.php';
require __DIR__.'/patient.php';