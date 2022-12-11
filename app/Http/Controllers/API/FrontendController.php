<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categorys;
use App\Models\Order;
use App\Models\Orderitems;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function indexProduct()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function indexCategory()
    {
        $category = Categorys::all();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function product($slug)
    {
        $category = Categorys::where('name', $slug)->first();
        if($category)
        {
            $product = Product::where('category_id', $category->id)->get();
            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product_data'=>[
                        'product'=>$product,
                        'category'=>$category,
                    ]
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'No Product Available'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found'
            ]);
        }
    }
    public function viewproduct($category_slug, $product_slug)
    {
        $category = Categorys::where('name',$category_slug)->first();
        if($category)
        {
            $product = Product::where('category_id', $category->id)->where('id',$product_slug)->first();
            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product'=>$product,
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'No Product Available'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found'
            ]);
        }
    }
    public function search($key){
        $product = Product::where('name','Like',"%$key%")->get();
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found'
            ]);
        }
    }
    
    public function viewOrder(){
        $orders = Order::all();
        return response()->json([
            'status' => 200,
            'orders' => $orders,
        ]);
    }

    public function detailOrderItems($order_id)
    {
        $orderItems = Orderitems::where('order_id',$order_id)->get();
        if($orderItems){
            return response()->json([
                'status' => 200,
                'orderItems' => $orderItems,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Không tìm thấy ID'
            ]);
        }
    }

}
