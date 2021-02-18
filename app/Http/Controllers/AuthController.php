<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function __construct(AuthService $authService)
    {
        $this->serviceInstance = $authService;
    }

    public function register(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = $this->serviceInstance->register($request->only('name', 'email', 'password'));

        return response()->json(['user' => $user, 'message' => 'User created!'], 201);
    }

    public function login(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $token = $this->serviceInstance->login($request->only(['email', 'password']));

        if (!$token) throw new UnauthorizedHttpException('', 'Unauthorized');

        return $this->respondWithToken($token);
    }


}
