<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\File\PDFController;


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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('prueba', function () {
    return 'api funcionando';
});

//Route::post('/pdf', [PdfController::class, 'store']);

//Route::get('/download/{folio}', [PdfController::class, 'download']);

Route::post('/pdf/upload', [PdfController::class, 'store']);
Route::post('/pdf/download', [PdfController::class, 'download']);
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);
Route::get('/user/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


