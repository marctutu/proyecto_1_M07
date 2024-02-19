<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('files', FileController::class);

Route::post('files/{file}', [FileController::class, 'update_workaround']);

Route::post('/register', [TokenController::class, 'register']);
Route::post('/login', [TokenController::class, 'login']);
Route::post('/logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [TokenController::class, 'user'])->middleware('auth:sanctum');

Route::apiResource('posts', App\Http\Controllers\Api\PostController::class);

Route::post('posts/{post}/likes', [App\Http\Controllers\Api\PostController::class, 'storeLike'])->name('posts.likes.store');
Route::delete('posts/{post}/likes/{like}', [App\Http\Controllers\Api\PostController::class, 'destroyLike'])->name('posts.likes.destroy');

