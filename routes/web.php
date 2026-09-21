<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
});

// Guest Form (Single-page No Scroll)
Route::get('/guest-form',         [TamuController::class, 'form']);
Route::post('/guest-form',        [TamuController::class, 'submit']);
Route::get('/guest-photo',        [TamuController::class, 'photo']);
Route::get('/guest-signature',    [TamuController::class, 'signature']);
Route::post('/submit-guest-data', [TamuController::class, 'submit']);

// Admin Auth (Public / Guest)
Route::get('/login',   [AdminController::class, 'loginPage']);
Route::post('/login',  [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout']);

// Protected Admin Routes & Dashboard APIs
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard',  [AdminController::class, 'dashboard']);
    Route::get('/admin/export-pdf', [AdminController::class, 'exportPdf']);

    // Admin APIs for dashboard
    Route::prefix('api')->group(function () {
        Route::get('/instansi',     [AdminController::class, 'getInstansi']);
        Route::get('/sekolah',      [AdminController::class, 'getSekolah']);
        Route::get('/schools',      [AdminController::class, 'getSchoolsList']);
        
        // Legacy aliases
        Route::get('/teachers',     [AdminController::class, 'getInstansi']);
        Route::get('/students',     [AdminController::class, 'getSekolah']);
        Route::get('/classes',      [AdminController::class, 'getSchoolsList']);

        Route::get('/data/{id}',    [AdminController::class, 'getData']);
        Route::put('/data/{id}',    [AdminController::class, 'updateData']);
        Route::delete('/data/{id}', [AdminController::class, 'deleteData']);
    });
});
