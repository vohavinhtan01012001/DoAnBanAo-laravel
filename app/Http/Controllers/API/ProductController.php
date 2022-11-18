<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'name' => 'required|max:191',
            'price' => 'required',
            'quantityM' => 'required',
            'quantityL' => 'required',
            'quantityXL' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image4' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $product = new Product;
            $product->category_id = $request->input('category_id');
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->quantityM = $request->input('quantityM');
            $product->quantityL = $request->input('quantityL');
            $product->quantityXL = $request->input('quantityXL');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image = 'uploads/product/' . $filename;
            }
            if ($request->hasFile('image2')) {
                $file = $request->file('image2');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '2' . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image2 = 'uploads/product/' . $filename;
            }
            if ($request->hasFile('image3')) {
                $file = $request->file('image3');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '3' . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image3 = 'uploads/product/' . $filename;
            }
            if ($request->hasFile('image4')) {
                $file = $request->file('image4');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '4' . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image4 = 'uploads/product/' . $filename;
            }
            $product->description = $request->input('description');
            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Thêm thành công!',
            ]);
        }
    }
    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm'
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'name' => 'required|max:191',
            'price' => 'required',
            'quantityM' => 'required',
            'quantityL' => 'required',
            'quantityXL' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image4' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $product = Product::find($id);
            if ($product) {
                $product->category_id = $request->input('category_id');
                $product->name = $request->input('name');
                $product->price = $request->input('price');
                $product->quantityM = $request->input('quantityM');
                $product->quantityL = $request->input('quantityL');
                $product->quantityXL = $request->input('quantityXL');
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/product/', $filename);
                    $product->image = 'uploads/product/' . $filename;
                }
                if ($request->hasFile('image2')) {
                    $file = $request->file('image2');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '2' . '.' . $extension;
                    $file->move('uploads/product/', $filename);
                    $product->image2 = 'uploads/product/' . $filename;
                }
                if ($request->hasFile('image3')) {
                    $file = $request->file('image3');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '3' . '.' . $extension;
                    $file->move('uploads/product/', $filename);
                    $product->image3 = 'uploads/product/' . $filename;
                }
                if ($request->hasFile('image4')) {
                    $file = $request->file('image4');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '4' . '.' . $extension;
                    $file->move('uploads/product/', $filename);
                    $product->image4 = 'uploads/product/' . $filename;
                }
                $product->description = $request->input('description');
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
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            @unlink($product->image);
            @unlink($product->image2);
            @unlink($product->image3);
            @unlink($product->image4);
            $product->delete();
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
