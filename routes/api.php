<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CategorysController;

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function(){
    Route::get('/checkingAuthenticated',function(){
        return response()->json(['message' => 'You are in','status' =>200],200);
    });
    Route::get('view-category', [CategorysController::class, 'index']);
    Route::post('store-category', [CategorysController::class, 'store']);
    Route::get('edit-category/{id}', [CategorysController::class, 'edit']);
    Route::put('upload-category/{id}', [CategorysController::class, 'update']);
    Route::delete('delete-category/{id}', [CategorysController::class, 'destroy']);
}); 
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout',[AuthController::class, 'logout']);
}); 
/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
