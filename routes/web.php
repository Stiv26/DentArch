<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Storage;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dentarch', [ArchiveController::class, 'index'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dentarch', [ArchiveController::class, 'index'])->name('archive.index');
    Route::post('/archive', [ArchiveController::class, 'store'])->name('archive.store');

    Route::get('/test-filebase', function () {
        try {
            Storage::disk('filebase')->put(
                'test.txt',
                'Hello Filebase!'
            );

            $content = Storage::disk('filebase')->get('test.txt');

            return response()->json([
                'status' => 'success',
                'content' => $content
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    });

    Route::get('/archive/{id}/edit', [ArchiveController::class, 'edit']);
    Route::put('/archive/{id}', [ArchiveController::class, 'update'])->name('archive.update');

    Route::get('/archive/{id}/show', [ArchiveController::class, 'show']);

    Route::delete('/file/{id}', [ArchiveController::class, 'destroy'])->name('file.delete');
    Route::delete('/file/remove/{id}', [ArchiveController::class, 'removeFile'])->name('file.remove');
});
