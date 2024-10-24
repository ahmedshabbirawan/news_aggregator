<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Article\App\Http\Controllers\ArticleController;

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
// ['auth:sanctum']
Route::middleware([])->prefix('v1')->name('api.')->group(function () {
  //  Route::get('article', fn (Request $request) => $request->user())->name('article');
    Route::get('article',[ArticleController::class,'index'] )->name('article');
});
