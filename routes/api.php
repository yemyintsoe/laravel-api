<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

# Just Testing
Route::get('test', function () {
    return response()->json("test from api.php");
});
# Get posts and store posts without authentication
Route::get('test-posts', [PostController::class, 'index']);
Route::post('test-posts', [PostController::class, 'store']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

# Posts crud routes (instead of these we use apiResource)
// Route::get('posts', [PostController::class, 'index']);
// Route::get('posts/{id}', [PostController::class, 'show']);
// Route::post('posts', [PostController::class, 'store']);
// Route::put('posts/{id}', [PostController::class, 'update']);
// Route::delete('posts/{id}', [PostController::class, 'destroy']);
