<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
});

// Guest Form
Route::get('/guest-form',         [TamuController::class, 'form']);
Route::post('/guest-form',        [TamuController::class, 'storeForm']);
Route::get('/guest-photo',        [TamuController::class, 'photo']);
Route::get('/guest-signature',    [TamuController::class, 'signature']);
Route::post('/submit-guest-data', [TamuController::class, 'submit']);

// Admin
Route::get('/login',           [AdminController::class, 'loginPage']);
Route::post('/login',          [AdminController::class, 'login']);
Route::post('/logout',         [AdminController::class, 'logout']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/export-pdf', [AdminController::class, 'exportPdf']);

// API Routes for Dashboard
Route::get('/api/teachers',     [AdminController::class, 'getTeachers']);
Route::get('/api/students',     [AdminController::class, 'getStudents']);
Route::get('/api/data/{id}',    [AdminController::class, 'getData']);
Route::put('/api/data/{id}',    [AdminController::class, 'updateData']);
Route::delete('/api/data/{id}', [AdminController::class, 'deleteData']);
