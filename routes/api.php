<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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

Route::controller(WriterController::class)->prefix('writers')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::post('/{id}', 'destroy');
    Route::get('/search/{name}', 'search');
});

Route::controller(PostController::class)->prefix('posts')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::post('/{id}', 'destroy');
    Route::get('/search/{name}', 'search');
});

Route::controller(CommentController::class)->prefix('comments')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::post('/{id}', 'destroy');
});


Route::controller(TagController::class)->prefix('tags')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::post('/{id}', 'destroy');
});

Route::post('/q', [TestController::class, 'index']);

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:api')->controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'index');
});
