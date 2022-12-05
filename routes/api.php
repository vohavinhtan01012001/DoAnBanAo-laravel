<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategorysController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\OrderController;

//Frontend
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('home-product', [FrontendController::class, 'indexProduct']);
Route::get('home-category', [FrontendController::class, 'indexCategory']);
Route::get('fetchproducts/{name}', [FrontendController::class, 'product']);
Route::get('viewproductdetail/{category_slug}/{product_slug}', [FrontendController::class, 'viewproduct']);
Route::get('search/{key}', [FrontendController::class, 'search']);

//cart
Route::post('add-to-cart', [CartController::class, 'addtocart']);
Route::get('cart', [CartController::class, 'viewcart']);
Route::put('cart-updatequantity/{cart_id}/{scope}', [CartController::class, 'updatequantity']);
Route::delete('delete-cartitem/{cart_id}', [CartController::class, 'deleteCartitem']);

Route::post('place-order', [CheckoutController::class, 'placeorder']);

//product_account
Route::get('view-orderItems', [OrderController::class, 'indexOrder']);


//Admin
Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {
    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    //Category
    Route::get('view-category', [CategorysController::class, 'index']);
    Route::post('store-category', [CategorysController::class, 'store']);
    Route::get('edit-category/{id}', [CategorysController::class, 'edit']);
    Route::put('upload-category/{id}', [CategorysController::class, 'update']);
    Route::delete('delete-category/{id}', [CategorysController::class, 'destroy']);
    Route::get('all-category', [CategorysController::class, 'allcategory']);

    //product
    Route::post('store-product', [ProductController::class, 'store']);
    Route::get('view-product', [ProductController::class, "index"]);
    Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    Route::post('update-product/{id}', [ProductController::class, "update"]);
    Route::delete('delete-product/{id}', [ProductController::class, 'destroy']);

    // Orders
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('detail-order/{id}', [OrderController::class, 'detail']);
    Route::delete('delete-order/{id}', [OrderController::class, 'destroy']);

    //Account
    Route::get('view-account', [AccountController::class, "index"]);
    Route::delete('delete-account/{id}', [AccountController::class, 'destroy']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
}); 
/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
