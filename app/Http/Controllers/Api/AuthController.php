<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller {
    public function login(Request $request) {
        $request->validate([
            'ssn'      => ['required'],
            'password' => ['required'],
        ]);
        $subscriber = Subscribers::where('ssn', $request->ssn)->first();
        if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $subscriber->createToken('subscriber_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
    public function logout(Request $request) {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $token?->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    public function user(Request $request) {
        $subscriber = PersonalAccessToken::findToken($request->bearerToken())?->tokenable;
        if (!$subscriber) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($subscriber);
    }
}
