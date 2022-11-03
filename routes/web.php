<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});



// Validate the given API token

Route::post('/api/validateToken',[\App\Http\Controllers\ApiController::class,'validateToken'])->name('tokenValidation');
Route::post('/api/generateImgId',[\App\Http\Controllers\ApiController::class,'generateImageId'])->name('imageIdGen');
Route::get('/image',[\App\Http\Controllers\ApiController::class,'viewImage'])->name('viewImage');
Route::post('/api/startTracking',[\App\Http\Controllers\ApiController::class,'startTracking'])->name('startTracking');
