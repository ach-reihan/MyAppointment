<?php

use Illuminate\Support\Facades\Route;

Route::get('/doctor', function () {
    return view('doctor.DashboardDoctor');
})->name('DashboardDoctor');

Route::get('/doctor/examination/index', function () {
    return view('doctor.examination.Index');
})->name('examination.Index'); 

Route::get('/doctor/examination/{id}', function ($id) {
    return view('doctor.examination.Show', ['id' => $id]);
})->name('examination.Show');

Route::get('/doctor/examination/{id}/detail', function ($id) {
    return view('doctor.examination.Detail', ['id' => $id]);
})->name('examination.Detail');

Route::get('/patient', function () {
    return view('patient.DashboardPatient');
})->name('DashboardPatient');

Route::get('/patient/FormAppointment', function () {
    return view('patient.FormAppointment');
})->name('FormAppointment');