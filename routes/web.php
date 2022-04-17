<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
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

Route::get('/', function () {
    return view('homepage');
})->name("homepage");

Auth::routes();

Route::get('/comments', [CommentController::class, "getComments"]);
Route::post('/comments', [CommentController::class, "store"])->name("comments.store");
Route::delete('/comments/{id}', [CommentController::class, "destroy"])->middleware('auth')->name("comments.delete");

Route::get('/post', [TestController::class, 'post'])->name('post');
//Route::get('/test', [TestController::class, 'getComments'])->name('getComments');
