<?php

namespace App\Http\Controllers;

use App\Services\CoinService;

class CoinController extends Controller
{
    private $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->middleware('auth');
        $this->coinService = $coinService;
    }

    public function getQuotation(string $coin) {
        $response = $this->coinService->getQuotation($coin);

        $response = [
            'buy'       => (float) $response['buy'],
            'sell'      => (float) $response['sell'],
            'last'      => (float) $response['last']
        ];

        return response()->json($response);
    }
}
