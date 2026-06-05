<?php

use Illuminate\Support\Facades\Route;

Route::prefix('patient')->name('patient.')->group(function () {
    
    // URL: /patient | Nama Rute: patient.dashboard
    Route::get('/', function () {
        return view('patient.DashboardPatient');
    })->name('dashboard');

    // URL: /patient/FormAppointment | Nama Rute: patient.FormAppointment
    Route::get('/FormAppointment', function () {
        return view('patient.FormAppointment');
    })->name('FormAppointment');

});