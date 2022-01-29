<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\WriterController;
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

/* writer */
Route::controller(WriterController::class)->group(function () {
    Route::get('/writers', 'index');
    Route::get('/writers/{id}', 'show');
    Route::post('/writers', 'store');
    Route::put('/writers', 'update');
    Route::post('/writers/{id}', 'destroy');
    Route::get('/writers/search/{name}', 'search');
});

/* post */
Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'index');
    Route::get('/posts/{id}', 'show');
    Route::post('/posts', 'store');
    Route::put('/posts', 'update');
    Route::post('/posts/{id}', 'destroy');
    Route::get('/posts/search/{name}', 'search');
});