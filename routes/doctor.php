<?php

use Illuminate\Support\Facades\Route;

Route::prefix('doctor')->name('doctor.')->group(function () {
    
    // URL: /doctor | Nama Rute: doctor.dashboard
    Route::get('/', function () {
        return view('doctor.DashboardDoctor');
    })->name('dashboard');

    // URL: /doctor/examination/index | Nama Rute: doctor.examination.Index
    Route::get('/examination/index', function () {
        return view('doctor.examination.Index');
    })->name('examination.Index'); 

    // URL: /doctor/examination/{id} | Nama Rute: doctor.examination.Show
    Route::get('/examination/{id}', function ($id) {
        return view('doctor.examination.Show', ['id' => $id]);
    })->name('examination.Show');

    // URL: /doctor/examination/{id}/detail | Nama Rute: doctor.examination.Detail
    Route::get('/examination/{id}/detail', function ($id) {
        return view('doctor.examination.Detail', ['id' => $id]);
    })->name('examination.Detail');

});