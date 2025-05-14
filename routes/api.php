<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\api\BarangApiController;
use App\Http\Controllers\api\KategoriApiController;
use App\Http\Controllers\api\PeminjamanApiController;
use App\Http\Controllers\api\PengembalianApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
}); 

Route::prefix('fe')->group(function () {
    Route::get('kategori', [KategoriApiController::class, 'index']);
    Route::get('barang', [BarangApiController::class, 'index']);
});
// routes/api.php
Route::middleware('auth:sanctum')->get('/barang', [BarangApiController::class, 'index']);



//baru
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/peminjaman', [PeminjamanApiController::class, 'store']);
    Route::get('/peminjaman', [PeminjamanApiController::class, 'index']);
    //  Route::get('/peminjaman/user', [PeminjamanApiController::class, 'getByUser']);
    // Pengembalian
    Route::get('/pengembalian', [PengembalianApiController::class, 'index']);
    Route::post('/pengembalian', [PengembalianApiController::class, 'store']);
});


