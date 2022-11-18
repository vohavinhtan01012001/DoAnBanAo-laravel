<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy tài khoản'
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $user = User::find($id);
            if ($user) {
                $user = new User;
                $user->name = $request->input('name');
                $user->address = $request->input('address');
                $user->phone = $request->input('phone');
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cập nhật thành công!',
                ]);
            } 
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cập nhật thất bại!',
                ]);
            }
        }
    }
}
