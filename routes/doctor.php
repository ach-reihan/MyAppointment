<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('doctor.DashboardDoctor');
})->name('DashboardDoctor');

Route::get('/examination/index', function () {
    return view('doctor.examination.Index');
})->name('examination.Index'); 

Route::get('/examination/{id}', function ($id) {
    return view('doctor.examination.Show', ['id' => $id]);
})->name('examination.Show');

Route::get('/examination/{id}/detail', function ($id) {
    return view('doctor.examination.Detail', ['id' => $id]);
})->name('examination.Detail');