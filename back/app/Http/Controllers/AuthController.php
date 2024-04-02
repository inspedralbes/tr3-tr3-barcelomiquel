<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'tipus' => 'string', // 'user' or 'admin
            'password' => 'required|string|min:6',
        ]);

        if ($request->tipus != null) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'tipus' => $request->tipus,
                'password' => bcrypt($request->password),
            ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'token' => $token,
                'name' => $user->name,
                'tipus' => $user->tipus,
                'email' => $user->email,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
