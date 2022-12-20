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
use App\Http\Controllers\API\PromotionController;

//Frontend
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('edit-user', [AuthController::class, 'edit']);
Route::get('home-product', [FrontendController::class, 'indexProduct']);
Route::get('home-category', [FrontendController::class, 'indexCategory']);
Route::get('fetchproducts/{name}', [FrontendController::class, 'product']);
Route::get('viewproductdetail/{category_slug}/{product_slug}', [FrontendController::class, 'viewproduct']);
Route::get('search/{key}', [FrontendController::class, 'search']);

//account
Route::get('home-order', [FrontendController::class, 'viewOrder']);
Route::get('home-orderItems/{id}', [FrontendController::class, 'detailOrderItems']);
Route::get('edit-account/{id}', [AccountController::class, 'edit']);
Route::put('update-account/{id}', [AccountController::class, 'update']);
Route::get('view-accountAdd', [AccountController::class, 'index']);



//cart
Route::post('add-to-cart', [CartController::class, 'addtocart']);
Route::get('cart', [CartController::class, 'viewcart']);
Route::put('cart-updatequantity/{cart_id}/{scope}', [CartController::class, 'updatequantity']);
Route::delete('delete-cartitem/{cart_id}', [CartController::class, 'deleteCartitem']);

//order
Route::post('place-order', [CheckoutController::class, 'placeorder']);

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
    Route::get('id-orders/{id}', [OrderController::class, 'indexOrderId']);
    Route::get('detail-order/{id}', [OrderController::class, 'detail']);
    Route::delete('delete-order/{id}', [OrderController::class, 'destroy']);
    Route::post('update-order/{id}', [OrderController::class, 'statusOrder']);

    //Account
    Route::get('view-account', [AccountController::class, "index"]);
    Route::delete('delete-account/{id}', [AccountController::class, 'destroy']);

    //Promotion
    Route::get('view-promotion', [PromotionController::class, "index"]);
    Route::post('store-promotion', [PromotionController::class, 'store']);
    Route::get('edit-promotion/{id}', [PromotionController::class, 'edit']);
    Route::put('upload-promotion/{id}', [PromotionController::class, 'update']);
    Route::delete('delete-promotion/{id}', [PromotionController::class, 'destroy']);
    
    Route::put('upload-productPro/{id}', [PromotionController::class, 'updateProduct']);
    Route::put('delete-productPro/{id}', [PromotionController::class, 'destroyProId']);
    


});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
}); 
/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
