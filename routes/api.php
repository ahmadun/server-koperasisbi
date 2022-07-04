<?php

use App\Http\Controllers\Api\AnggotaContoller;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BelanjaKontanController;
use App\Http\Controllers\Api\KasbonController;
use App\Http\Controllers\Api\PinjamanController;
use App\Http\Controllers\api\SalaryController;
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
Route::post('/auth/updateuser',[AuthController::class,'updateUser'])->middleware('auth:sanctum');
Route::post('/auth/updateemail',[AuthController::class,'updateEmailNo'])->middleware('auth:sanctum');
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/simpanan',[SimpananController::class,'index'])->middleware('auth:sanctum')->middleware('auth:sanctum');
Route::get('/simpanan/mail',[SimpananController::class,'SendmailSimpanan'])->middleware('auth:sanctum');
Route::get('/pinjaman',[PinjamanController::class,'index'])->middleware('auth:sanctum')->middleware('auth:sanctum');
Route::get('/pinjaman/detail',[PinjamanController::class,'detail_pinjaman'])->middleware('auth:sanctum');
Route::get('/pinjaman/mail/reg',[PinjamanController::class,'SendmailpinjamanReg'])->middleware('auth:sanctum');
Route::get('/pinjaman/mail/kons',[PinjamanController::class,'SendmailpinjamanKons'])->middleware('auth:sanctum');
Route::get('/checknama',[AnggotaContoller::class,'CheckAnggota']);
Route::get('/checkkasbon',[KasbonController::class,'index']);
Route::post('/savetrans',[KasbonController::class,'SaveTransaksi']);
Route::post('/saveblgkontan',[BelanjaKontanController::class,'SaveTransaksi']);
Route::post('/uploadsalary',[SalaryController::class,'UploadData']);