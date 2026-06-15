<?php

namespace App\Services\Api;

use App\Models\Subscribers;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService {
    public function __construct(){}
    public function getAuthedUser(array $data){
        return Subscribers::where('ssn', $data['ssn'])->first();
    }
    public function getToken(object $data){
        return PersonalAccessToken::findToken($data->bearerToken())?->tokenable;
    }
}
