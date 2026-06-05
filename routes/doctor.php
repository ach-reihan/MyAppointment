<?php

use Illuminate\Support\Facades\Route;

// Bungkus semua rute dengan prefix 'doctor' dan name 'doctor.'
Route::prefix('doctor')->name('doctor.')->group(function () {
    
    // URL: /doctor/dashboard | Route Name: doctor.dashboard
    Route::get('/dashboard', function () {
        return view('doctor.DashboardDoctor');
    })->name('dashboard');

    Route::get('/examination/index', function () {
        return view('doctor.examination.Index');
    })->name('examination.Index'); 

    Route::get('/examination/{id}', function ($id) {
        return view('doctor.examination.Show', ['id' => $id]);
    })->name('examination.Show');

    Route::get('/examination/{id}/detail', function ($id) {
        return view('doctor.examination.Detail', ['id' => $id]);
    })->name('examination.Detail');

});