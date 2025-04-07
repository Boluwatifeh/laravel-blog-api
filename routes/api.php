<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


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
    Route::get("/posts", [PostController::class, "getPosts"]);
    Route::put("/posts/{id}", [PostController::class, "editPost"]);
    Route::delete("/posts/{id}", [PostController::class, "deletePost"]);
    Route::get("/posts/{id}", [PostController::class, "getPost"]);
    });
