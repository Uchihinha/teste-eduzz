<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->serviceInstance = $userService;
    }

    public function getBalance() : JsonResponse {
        $user = $this->serviceInstance->find(Auth::user()->id);

        return response()->json([
            'balance'  => $user->balance
        ]);
    }


}
