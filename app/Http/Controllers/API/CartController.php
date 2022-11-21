<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addtocart(Request $request)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $size = $request->size;
            $product_qty = $request->product_qty;

            $productCheck = Product::where('id', $product_id)->first();
            if ($productCheck) {
                if (Cart::where('product_id', $product_id)->where('user_id', $user_id)->where('size', $size)->exists()) {
                    return response()->json([
                        'status' => 409,
                        'message' => $productCheck->name . ' đã thêm vào giỏ hàng',
                    ]);
                }
                else {
                    $cartitem = new Cart;
                    $cartitem->user_id = $user_id;
                    $cartitem->product_id = $product_id;
                    $cartitem->size = $size;
                    $cartitem->product_qty = $product_qty;
                    $cartitem->save();
                    return response()->json([
                        'status' => 201,
                        'message' => 'Thêm thành công!',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Sản phẩm không tìm thấy',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Vui lòng đăng nhập trước khi thêm vào giỏ hàng!',
            ]);
        }
    }
    public function viewcart()
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartitems = Cart::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 200,
                'cart' => $cartitems,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Vui lòng đăng nhập trước khi vào giỏ hàng!',
            ]);
        }
    }
    public function updatequantity($cart_id, $scope)
    {
        if(auth('sanctum')->check())
        {
            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();
            $productCheck = Product::where('id',$cartitem->product_id)->first();
            if($scope == "inc"){
                if(($cartitem->product_qty < $productCheck->quantityM  && $cartitem->size == "M")
                ||($cartitem->product_qty < $productCheck->quantityL && $cartitem->size == "L")
                ||($cartitem->product_qty < $productCheck->quantityXL && $cartitem->size == "XL"))
                {
                    $cartitem->product_qty += 1;
                }
                else{
                    $cartitem->product_qty += 0;
                }
            }else if($scope == "dec"){
                if($cartitem->product_qty > 1)
                {
                    $cartitem->product_qty -= 1;
                }
                else{
                    $cartitem->product_qty -= 0;
                }
            }
            $cartitem->update();
            return response()->json([
                'status'=> 200,
                'message'=> 'số lượng đã được cập nhật',
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 401,
                'message'=> 'Đăng nhập để tiếp tục',
            ]);
        }
    }
    
    public function deleteCartitem($cart_id)
    {
        if(auth('sanctum')->check())
        {
            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();
            if($cartitem)
            {
                $cartitem->delete();
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Cart Item Removed Successfully.',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'message'=> 'Cart Item not Found',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=> 401,
                'message'=> 'Login to continue',
            ]);
        }
    }
}
