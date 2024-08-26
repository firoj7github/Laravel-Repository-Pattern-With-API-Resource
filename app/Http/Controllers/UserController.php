<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
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

    public function registeruser(Request $request) {
        // Define validation rules and custom messages
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:40',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please provide a valid email address.',
            'email.max'         => 'Email may not be greater than 40 characters.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }

        // Create a new user instance with validated data
        $user = User::create([
            'name'    => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            // Optionally add other fields if necessary
        ]);

        // Generate an access token for the user
        $token = $user->createToken('Token')->accessToken;

        // Prepare user data with token
        $user_data = [
            'token' => $token,
            'user'  => new UserResource($user),
        ];

        // Return success response with user data
        return response()->json([
            'status' => 'success',
            'data'   => $user_data,
        ]);
    }
}
