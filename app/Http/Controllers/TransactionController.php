<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(TransactionService $transactionService)
    {
        $this->middleware('auth');
        $this->serviceInstance = $transactionService;
    }

    public function deposit(Request $request) : JsonResponse {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0.01'
        ]);

        $params = $request->only('amount');

        $params['description'] = 'Deposit';

        $this->serviceInstance->add($params);

        return response()->json([
            'message'   => 'Deposited!'
        ], 201);

    }

    public function get(Request $request) : JsonResponse {
        $data = $this->serviceInstance->getResume($request->days ?: 90);

        return response()->json($data);
    }

    public function getDailyVolume() : JsonResponse{
        $data = $this->serviceInstance->getDailyVolume();

        return response()->json($data);
    }


}
