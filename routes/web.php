<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('admin-login');
});

Route::post('/login', function () {
    request()->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    return back()->with('success', 'Login admin belum diaktifkan.');
});

Route::get('/guest-form',      [TamuController::class, 'form']);
Route::post('/guest-form',     [TamuController::class, 'storeForm']);

Route::get('/guest-photo',     [TamuController::class, 'photo']);
Route::post('/guest-photo',    [TamuController::class, 'storePhoto']);

Route::get('/guest-signature', [TamuController::class, 'signature']);
Route::post('/submit-guest-data', [TamuController::class, 'submit']);
