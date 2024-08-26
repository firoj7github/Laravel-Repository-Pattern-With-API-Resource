<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginuser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|max:40',
            'password' => 'required|min:6',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        $input = $request->all();

        if (Auth::attempt($input)) {
            $user = Auth::user();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $user_data = [
                'token' => $token,
                'user' => new UserResource($user),
            ];
            return response()->json(['status' => 'success', 'message' => 'Login Successful', 'user_data' => $user_data]);
        } else {
            return response()->json(['status' => false, 'message' => 'The credentials does not match']);
        }
    }
}
