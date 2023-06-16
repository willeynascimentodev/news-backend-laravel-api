<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function store(Request $req) {
        $credentials = request(['email', 'password']);

        if (!$req->email || !$req->password) {
            return response()->json(['error' => 'Invalid Parameters'], 400);
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'data' => [
                'token' => $token,
                'email' => $req->email
            ],
            'message' => 'Token generated'
            ], 201);
    }

    public function destroy() {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
