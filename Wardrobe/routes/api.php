<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClothingItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OutfitController;
use App\Http\Controllers\Api\TagController;

// Public authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Resource routes
    Route::apiResource('users', UserController::class);
    Route::apiResource('clothing-items', ClothingItemController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('outfits', OutfitController::class);
    Route::apiResource('tags', TagController::class);
    
    // Custom routes for managing tags on clothing items
    Route::get('clothing-items/{id}/tags', [ClothingItemController::class, 'tags']);
    Route::post('clothing-items/{id}/tags', [ClothingItemController::class, 'attachTag']);
    Route::delete('clothing-items/{id}/tags/{tagId}', [ClothingItemController::class, 'detachTag']);
});
