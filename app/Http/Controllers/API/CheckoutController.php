<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{
    public function placeorder(Request $request)
    {
        if(auth('sanctum')->check())
        {
            $validator = Validator::make($request->all(), [
                'name'=>'required|max:191',
                'phone'=>'required|max:191',
                'address'=>'required|max:191',
            ]);

            if($validator->fails())
            {
                return response()->json([
                    'status'=>422,
                    'errors'=>$validator->errors(),
                ]);
            }
            else
            {
                $user_id = auth('sanctum')->user()->id;
                $order = new Order;
                $order->user_id = $user_id;
                $order->name = $request->name;
                $order->phone = $request->phone;
                $order->address = $request->address;

                /* $order->payment_mode = $request->payment_mode;
                $order->payment_id = $request->payment_id;
                $order->tracking_no = 'fundaecom'.rand(1111,9999); */
                $order->save();

                $cart = Cart::where('user_id', $user_id)->get();

                $orderitems = [];
                foreach($cart as $item){
                    if($item->size == "M"){
                        $orderitems[] = [
                            'product_id'=>$item->product_id,
                            'qtyM'=>$item->product_qty,
                            'price'=>$item->product->price,
                            'sumPrice'=>$item->product->price * $item->product_qty,
                        ];
                        $item->product->update([
                            'quantityM'=>($item->product->quantityM - $item->product_qty)
                        ]);
                    }
                    if($item->size == "L"){
                        $orderitems[] = [
                            'product_id'=>$item->product_id,
                            'qtyL'=>$item->product_qty,
                            'price'=>$item->product->price,
                            'sumPrice'=>$item->product->price * $item->product_qty,
                        ];
                        $item->product->update([
                            'quantityL'=>($item->product->quantityL - $item->product_qty)
                        ]);
                    }
                    if($item->size == "XL"){
                        $orderitems[] = [
                            'product_id'=>$item->product_id,
                            'qtyXL'=>$item->product_qty,
                            'price'=>$item->product->price,
                            'sumPrice'=>$item->product->price * $item->product_qty,
                        ];
                        $item->product->update([
                            'quantityXL'=>($item->product->quantityXL - $item->product_qty)
                        ]);
                    }

                }

                $order->orderitems()->createMany($orderitems);
                Cart::destroy($cart);

                return response()->json([
                    'status'=>200,
                    'message'=>'Order Placed Successfully',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=> 401,
                'message'=> 'Login to Continue',
            ]);
        }
    }

}
