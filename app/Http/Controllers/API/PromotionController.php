<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotion = Promotion::all();
        return response()->json([
            'status' =>  200,
            'promotion' => $promotion
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => 'required',
            'title' => 'required|max:191',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {
            $promotion = new Promotion;
            $promotion->discount = $request->input('discount');
            $promotion->title = $request->input('title');
            $promotion->save();
            return response()->json([
                'status' => 200,
                'message' => 'Thêm thành công'
            ]);
        }
    }

    public function edit($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            return response()->json([
                'status' => 200,
                'promotion' => $promotion
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy ID'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'discount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $promotion = Promotion::find($id);
            if ($promotion) {
                $promotion->discount = $request->input('discount');
                $promotion->title = $request->input('title');
                $promotion->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cập nhật thành công'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cập nhật thất bại',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            $promotion->delete();
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
    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->promotion_id = $request->input('promotion_id');
            $product->update();
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Cập nhật thất bại!',
            ]);
        }
    }
    public function destroyProId($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->promotion_id = 0;
            $product->update();
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Cập nhật thất bại!',
            ]);
        }
    }
}
