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
Route::get('/writers', [WriterController::class, 'index']);

Route::get('/writer/{id}', [WriterController::class, 'show']);

Route::post('/writer', [WriterController::class, 'store']);

Route::put('/writer/{id}', [WriterController::class, 'update']);

Route::post('/writer/{id}', [WriterController::class, 'destroy']);

Route::get('/writer/search/{name}', [WriterController::class, 'search']);

/* post */
Route::get('/posts', [PostController::class, 'index']);

Route::get('/post/{id}', [PostController::class, 'show']);

Route::post('/post', [PostController::class, 'store']);

Route::put('/post/{id}', [PostController::class, 'update']);

Route::post('/post/{id}', [PostController::class, 'destroy']);

Route::get('/post/search/{name}', [PostController::class, 'search']);
