<?php
use App\Http\Controllers\Doctor\ExaminationController;
use App\Http\Controllers\Doctor\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('doctor')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('DashboardDoctor');
    
    Route::get('/examination', [ExaminationController::class, 'index'])->name('examination.Index');
    Route::get('/examination/{id}', [ExaminationController::class, 'show'])->name('examination.Show');
    Route::get('/examination/{id}/detail', [ExaminationController::class, 'detail'])->name('examination.Detail');
    
    Route::post('/examination/{id}', [ExaminationController::class, 'store'])->name('examination.Store');
    Route::post('/appointment/{id}/approve', [ExaminationController::class, 'approve'])->name('examination.Approve');
    Route::post('/appointment/{id}/cancel', [ExaminationController::class, 'cancel'])->name('examination.Cancel');
});