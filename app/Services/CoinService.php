<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CoinService
{
    private $baseUrl = 'https://www.mercadobitcoin.net/api/';

    public function getQuotation(string $coin = 'BTC') {
        $response = Http::get($this->baseUrl .  $coin . '/ticker');

        if (!$response['ticker']) throw new NotFoundHttpException('Coin ticker not found');

        return $response['ticker'];
    }

}
