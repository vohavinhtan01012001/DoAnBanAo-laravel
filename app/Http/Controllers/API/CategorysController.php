<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categorys;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategorysController extends Controller
{
    public function index()
    {
        $category = Categorys::all();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function allcategory(){
        $category = Categorys::get();
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }


    public function edit($id)
    {
        $category = Categorys::find($id);
        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Category Id Found'
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {
            $category = new Categorys;
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category Added Successfully',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $category = Categorys::find($id);
            if ($category) {
                $category = new Categorys;
                $category->name = $request->input('name');
                $category->description = $request->input('description');
                $category->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Added Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No category ID found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $category = Categorys::find($id);
        if ($category) {
            $category->delete();
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
