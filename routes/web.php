<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TestController;

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

// Route::get('/', function () {
//     // return redirect(storage_path('/images/7o7uUg1ZKui7amXdLVrtRC6HwcVG8z34wyTAoZ6I.jpg'));
//     // return redirect(public_path('storage\images\7o7uUg1ZKui7amXdLVrtRC6HwcVG8z34wyTAoZ6I.jpg'));
//     return view('welcome');
// });

Route::get('/upload', function () {
    return view('upload');
});

Route::get('/', [TestController::class, 'index']);
Route::post('/upload', [UploadController::class, 'index'])->name('postFile');
