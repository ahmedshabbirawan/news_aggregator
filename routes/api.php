<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Article\App\Http\Controllers\ArticleController;
use Modules\NewsData\App\Http\Controllers\NewsDataController;
use Modules\Auth\App\Http\Controllers\AuthController;
use Modules\User\App\Http\Controllers\UserPreferencesController;

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

// Auth
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('news',[ArticleController::class,'getNews']);
    Route::get('news/{id}',[ArticleController::class,'getNewsDetail']);
    Route::get('/preferences', [UserPreferencesController::class, 'getPreferencesPageResources']);
    Route::post('/preferences', [UserPreferencesController::class, 'savePreferences']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
