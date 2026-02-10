<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check static credentials
        if (
            $request->username !== env('API_STATIC_USER') ||
            $request->password !== env('API_STATIC_PASSWORD')
        ) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Sanctum needs a User model
        $user = User::firstOrCreate(
            ['email' => 'api@system.local'],
            [
                'name' => 'Static API User',
                'password' => Hash::make(env('API_STATIC_PASSWORD')),
            ]
        );

        // Create token
        $token = $user->createToken('static-api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
