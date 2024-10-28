<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix("user")->group(function () {
        Route::get('/profile', [UserController::class, 'show']);
        Route::put('/profile/update', [UserController::class, 'update']);
        Route::delete('/profile/delete', [UserController::class, 'delete']);
        Route::get('/commented-posts', [PostController::class, 'commentedPosts']);
        Route::get('/liked-posts', [PostController::class, 'likedPosts']);
    });

    Route::prefix("posts")->group(function () {
        Route::get('/', [PostController::class, 'list']);
        Route::post('/store', [PostController::class, 'store']);
        Route::put('/update/{id}', [PostController::class, 'update']);
        Route::delete('/delete/{id}', [PostController::class, 'delete']);

        Route::prefix("{postId}")->group(function () {
            Route::post('/comment', [CommentController::class, 'store']);
            Route::post('/like', [PostController::class, 'like']);
        });
    });
    
    Route::post('/comments/{id}/like', [CommentController::class, 'like']);

});