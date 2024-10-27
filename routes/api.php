<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\NewsData\App\Http\Controllers\NewsDataController;
use Modules\Auth\App\Http\Controllers\AuthController;

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

// News Article
Route::get('news-fetch',[NewsDataController::class,'newsFetch']);
Route::get('news',[NewsDataController::class,'getNews']);
Route::get('news/{id}',[NewsDataController::class,'getNewsDetail']);


// Auth
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
