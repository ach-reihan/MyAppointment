<?php
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\FormController;
use Illuminate\Support\Facades\Route;

Route::prefix('patient')->middleware(['auth', 'role:patient'])->group(function () {
    
    // We register both names to support both standard redirect names and layout views
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient', [PatientController::class, 'dashboard'])->name('DashboardPatient');
    
    Route::get('/FormAppointment', [FormController::class, 'createAppointment'])->name('FormAppointment');
    Route::post('/FormAppointment', [FormController::class, 'storeAppointment'])->name('FormAppointment.store');
    
    Route::get('/medical-history', [PatientController::class, 'medicalHistory'])->name('patient.MedicalHistory');
    Route::get('/appointment/{id}/detail', [PatientController::class, 'showAppointmentDetail'])->name('patient.appointment.detail');
    Route::get('/medical-history/{id}/detail', [PatientController::class, 'medicalHistoryDetail'])->name('patient.MedicalHistory.Detail');
});