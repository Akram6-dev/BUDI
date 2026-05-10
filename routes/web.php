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
Route::post('/guest-photo',       [TamuController::class, 'storePhoto']);
Route::get('/guest-signature',    [TamuController::class, 'signature']);
Route::post('/submit-guest-data', [TamuController::class, 'submit']);

// Admin
Route::get('/login',           [AdminController::class, 'loginPage']);
Route::post('/login',          [AdminController::class, 'login']);
Route::post('/logout',         [AdminController::class, 'logout']);
Route::get('/admin/dashboard', function () {
    if (!session('admin_logged_in')) return redirect('/login');
    return view('admin.dashboard');
});
