<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderitems;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => 200,
            'orders' => $orders,
        ]);
    }
    public function indexOrder()
    {
        if(auth('sanctum')->check())
        {
            $user_id = auth('sanctum')->user()->id;
            $order = Order::where('user_id', $user_id)->get();
            $orderItems= [];
            foreach($order as $item){
                $orderItems = Orderitems::where('order_id', $item->id)->get();
            }
            return response()->json([
                'status' => 200,
                'orderItems' => $orderItems,
            ]);
        }
    }
    public function detail($order_id)
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
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa thành công!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy ID'
            ]);
        }
    }
}
