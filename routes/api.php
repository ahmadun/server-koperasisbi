<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PinjamanController;
use App\Http\Controllers\Api\SimpananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth/register',[AuthController::class,'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/simpanan',[SimpananController::class,'index']);
Route::get('/simpanan/mail',[SimpananController::class,'SendMailpinjaman']);
Route::get('/pinjaman',[PinjamanController::class,'index']);
Route::get('/pinjaman/detail',[PinjamanController::class,'detail_pinjaman']);
