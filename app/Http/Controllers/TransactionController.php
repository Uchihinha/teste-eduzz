<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $params['user_id'] = Auth::user()->id;
        $params['description'] = 'Deposit';

        $this->serviceInstance->add($params);

        return response()->json([
            'message'   => 'Deposited!'
        ], 201);

    }


}
