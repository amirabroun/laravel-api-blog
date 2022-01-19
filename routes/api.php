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

Route::post('/writer', [WriterController::class, 'store']);

Route::get('/writer/{id}', [WriterController::class, 'show']);

Route::put('/writer/{id}', [WriterController::class, 'update']);

Route::post('/writer/{id}', [WriterController::class, 'destroy']);

Route::get('/writer/search/{name}', [WriterController::class, 'search']);

/* post */
Route::get('/posts', [PostController::class, 'index']);

Route::post('/post', [PostController::class, 'store']);

Route::get('/post/{title}', [PostController::class, 'show']);

Route::put('/post/{title}', [PostController::class, 'update']);

Route::post('/post/{title}', [PostController::class, 'destroy']);

Route::get('/post/search/{name}', [PostController::class, 'search']);
