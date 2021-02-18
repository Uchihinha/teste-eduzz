<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService extends Service
{
    public function __construct(User $user)
    {
        $this->modelInstance = $user;
    }

    public function register(array $data) : User {
        $data['password'] = app('hash')->make($data['password']);

        $user = $this->modelInstance->create($data);

        return $user;
    }

    public function login(array $credentials) : string {
        $token = Auth::attempt($credentials);

        return $token;
    }
}
