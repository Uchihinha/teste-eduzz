<?php

namespace App\Http\Controllers;

use App\Services\CoinService;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function __construct(CoinService $coinService)
    {
        $this->middleware('auth');
        $this->serviceInstance = $coinService;
    }

    public function getQuotation(string $coin) {
        $response = $this->serviceInstance->getQuotation($coin);

        $response = [
            'buy'       => (float) $response['buy'],
            'sell'      => (float) $response['sell'],
            'last'      => (float) $response['last']
        ];

        return response()->json($response);
    }

    public function buy(Request $request, string $coin ) {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0.01',
        ]);

        $buyInstance = $this->serviceInstance->buy($coin, (float) $request->amount);

        return response()->json([
            'message'   => 'Buy',
            'data'      => $buyInstance
        ], 201);
    }

    public function sell(Request $request, string $coin ) {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0.01',
        ]);

        $this->serviceInstance->sell($coin, (float) $request->amount);

        return response()->json([
            'message'   => 'Sell'
        ], 201);
    }
}
