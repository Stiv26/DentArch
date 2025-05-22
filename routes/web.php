<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\PatientController;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/', [ArchiveController::class, 'index'])->middleware('auth');

Route::delete('/files/{id}', [ArchiveController::class, 'destroy'])
    ->name('file.delete')
    ->middleware('auth');

Route::post('/upload', [ArchiveController::class, 'store'])
    ->name('upload.store')
    ->middleware('auth');

Route::post('/patients', [PatientController::class, 'store'])
    ->name('patients.store')
    ->middleware('auth');

Route::post('/upload', [ArchiveController::class, 'store'])
    ->name('upload.store')
    ->middleware('auth');
