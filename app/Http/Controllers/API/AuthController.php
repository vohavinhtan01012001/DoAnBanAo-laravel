<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\Email;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($user->role_as == 1) //Admin
            {
                $role = 'admin';
                $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
            } else {
                $role = '';
                $token = $user->createToken($user->email . '_token', [''])->plainTextToken;
            }
            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' => $token,
                'email' => $user->email,
                'role' => $role,
                'message' => 'Chúc mừng bạn đã đăng ký thành công!',
            ]);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Thông tin đăng nhập không hợp lệ!',
                ]);
            } else {
                if ($user->role_as == 1) //Admin
                {
                    $role = 'admin';
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                } else {
                    $role = '';
                    $token = $user->createToken($user->email . '_token', [''])->plainTextToken;
                }
                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'token' => $token,
                    'email' => $user->email,
                    'role' => $role,
                    'message' => 'Chúc mừng bạn đã đăng nhập thành công!',
                ]);
            }
        }
    }
    public function logout()
    {

        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            'status' => 200,
            'message' => 'Bạn đã đăng xuất thành công!'
        ]);
    }
}
