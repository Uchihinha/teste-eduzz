<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\Notify;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        dispatch(new SendEmail(Auth::user()->email, [
            'type'      => 'deposit',
            'amount'    => number_format($request->amount, 2, ',', '.'),
        ]));

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
