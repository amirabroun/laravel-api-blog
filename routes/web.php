<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Models\User;
use PHPUnit\Framework\Test;

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

Route::get('/', [TestController::class, 'index']);

Route::get('/upload', function () {
    return view('upload');
})->name('upload');

Route::post('/upload', [UploadController::class, 'index'])->name('postFile');
