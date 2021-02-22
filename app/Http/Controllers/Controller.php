<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $serviceInstance;

    protected function respondWithToken(string $token) : JsonResponse
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 6000
        ], 200);
    }

    public function get(Request $request) : JsonResponse {
        $data = $this->serviceInstance->get();

        return response()->json($data);
    }
}
