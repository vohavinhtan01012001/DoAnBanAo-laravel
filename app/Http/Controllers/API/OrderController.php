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

    public function indexOrderId($id)
    {
        $order = Order::where('id', $id)->get();
        return response()->json([
            'status' => 200,
            'order' => $order,
        ]);
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
    public function statusOrder($id) {
        $order = Order::find($id);
        if($order->status == 0){
            $order->status = 1;
        }
        $order->update();
        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật thành công!',
        ]);
    }
}
