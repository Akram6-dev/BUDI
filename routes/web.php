<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AdminController;

// Guest Kiosk SPA (Single-page No Reload - Keeps Fullscreen uninterrupted)
Route::get('/',                   [TamuController::class, 'form']);

// Guest Form (Single-page No Scroll)
Route::get('/guest-form',         [TamuController::class, 'form']);
Route::post('/guest-form',        [TamuController::class, 'submit']);
Route::get('/guest-photo',        [TamuController::class, 'photo']);
Route::get('/guest-signature',    [TamuController::class, 'signature']);
Route::post('/submit-guest-data', [TamuController::class, 'submit']);

// Direct file serving fallback for Web Hosting (cPanel / Shared Hosting without symlink / storage:link)
Route::get('/storage/{folder}/{filename}', function ($folder, $filename) {
    // 1. Check storage/app/public/$folder/$filename
    $path = storage_path("app/public/{$folder}/{$filename}");

    // 2. Check public/storage/$folder/$filename (fallback)
    if (!file_exists($path)) {
        $path = public_path("storage/{$folder}/{$filename}");
    }

    if (!file_exists($path) || !is_file($path)) {
        abort(404);
    }

    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = match ($extension) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png'         => 'image/png',
        'webp'        => 'image/webp',
        'gif'         => 'image/gif',
        default       => mime_content_type($path) ?: 'application/octet-stream',
    };

    return response()->file($path, [
        'Content-Type'  => $mime,
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('folder', 'foto|tanda_tangan')->where('filename', '[A-Za-z0-9_\-\.]+');

// Admin Auth (Public / Guest)
Route::get('/login',   [AdminController::class, 'loginPage']);
Route::post('/login',  [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout']);

// Protected Admin Routes & Dashboard APIs
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard',  [AdminController::class, 'dashboard']);
    Route::get('/admin/export-pdf', [AdminController::class, 'exportPdf']);
    Route::get('/admin/export-excel', [AdminController::class, 'exportExcel']);

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
