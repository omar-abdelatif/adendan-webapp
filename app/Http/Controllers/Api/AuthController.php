<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller {
    public function __construct(protected AuthService $authService) {}
    public function login(Request $request) {
        $request->validate([
            'ssn'      => ['required'],
            'password' => ['required'],
        ]);
        $subscriber = $this->authService->getAuthedUser($request->ssn);
        if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $subscriber->tokens()->delete();
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
        $subscriber = $this->authService->getToken($request);
        if (!$subscriber) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($subscriber);
    }
}
