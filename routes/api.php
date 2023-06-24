<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GambarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// upload gambar
// Route::post('lihat-semua-foto', [GambarController::class, 'index']);
Route::post('unggah-foto-profile', [GambarController::class, 'store']);
Route::put('update-gambar/{id}', [GambarController::class, 'update']);
Route::post('delete-gambar/{id}', [GambarController::class, 'delete']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin', [AuthController::class, 'admin'])->middleware('auth:api', 'ceklevel:admin');

    Route::post('/read/{id}', [UserController::class, 'read']);
    // Route::get('/index', [UserController::class, 'index']);

    Route::post('/update/{id}', [UserController::class, 'update'])->middleware('adminOrSelf');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->middleware('adminOrSelf');

    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::post('/edit', [ProfileController::class, 'edit']);
    Route::delete('/destroy', [ProfileController::class, 'destroy']);
});
