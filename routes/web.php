<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/guest-form', function () {
    return view('guest-form');
});

Route::post('/submit-guest-data', function () {
    // This will be implemented later
    return response()->json(['status' => 'success']);
});
