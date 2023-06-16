<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FilterController;


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

Route::resource('auth', AuthController::class)->only([
    'store'
]);


Route::middleware('jwt.verify')->group(function() {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/feed', [ArticleController::class, 'feed']);
    Route::get('/filters', [FilterController::class, 'getFilters']);
    Route::post('/filters', [FilterController::class, 'store']);
    Route::delete('/filters/{id}', [FilterController::class, 'destroy']);
    Route::delete('/auth', [AuthController::class, 'destroy']);
});

