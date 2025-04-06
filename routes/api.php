<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('/register', [AuthController::class, 'register']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/hello", function () {
    return response()->json([
        "message" => "Hello World"
    ]);
}); 

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]); 

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    // Add other routes that require authentication here
    Route::post("/posts", [PostController::class, "createPost"]);
    });
