<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user && $user->role_as == 0 || $user->role_as == 2) {
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa thành công!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không được xóa Quản trị viên!'
            ]);
        }
    }
    public function edit($id)
    {
        $User = User::find($id);
        if ($User) {
            return response()->json([
                'status' => 200,
                'user' => $User
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Category Id Found'
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
            $user->email = $user->email;
            $user->password = $user->password;
            $user->role_as = $user->role_as;
            $user->name = $request->input('name');
            $user->address = $request->input('address');
            $user->phone = $request->input('phone');
            $user->update();
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công',
            ]);
            /* } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cập nhật thất bại',
                ]);
            } */
        }
    }
}
