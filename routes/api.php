<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\controllers\ArticleController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// getting all articles
Route::get('/index', [ArticleController::class, 'index']);

// create article
Route::post('/article/create', [ArticleController::class, 'store']);

// show article
Route::get('/article/{id}', [ArticleController::class, 'show']);

// update article
Route::put('/article/edit', [ArticleController::class, 'store']);

// delete article
Route::delete('/delete/{id}', [ArticleController::class, 'destroy']);




