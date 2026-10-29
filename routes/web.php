<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/patients');
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/export', [PatientController::class, 'export'])->name('patients.export');
