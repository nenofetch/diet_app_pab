<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'work' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'work' => $request->work,
        ])->assignRole('user');

        $token = $user->createToken('AuthApp')->plainTextToken;

        return ResponseFormatter::success([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 'Berhasil Mendaftar');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            //            $token = Auth::user()->createToken('AuthApp')->accessToken;
            // retrieve latest user from credentials
            $user = User::where('email', $request->email)->first();

            //displaying token for issue
            $token = $user->createToken('AuthApp')->plainTextToken;
            return ResponseFormatter::success([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Authtenticated Success');
        } else {
            return ResponseFormatter::error(['message' => 'Failed Authenticated'], 'Auth Fail', 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
