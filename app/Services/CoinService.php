<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CoinService
{
    private $baseUrl = 'https://www.mercadobitcoin.net/api/';

    private $userService;

    private $transactionService;

    private $portfolioService;

    public function __construct(UserService $userService, TransactionService $transactionService, PortfolioService $portfolioService)
    {
        $this->userService = $userService;
        $this->transactionService = $transactionService;
        $this->portfolioService = $portfolioService;
    }

    public function getQuotation(string $coin = 'BTC') : array {
        $response = Http::get($this->baseUrl .  $coin . '/ticker');

        if (!$response['ticker']) throw new NotFoundHttpException('Coin ticker not found');

        return $response['ticker'];
    }

    public function buy(string $coin = 'BTC', float $amount) : Portfolio {
        $sellOffer = (float) $this->getQuotation($coin)['sell'];

        $this->userService->validateBalance($amount);

        $this->transactionService->sub([
            'ticker'        => $coin,
            'amount'        => $amount,
            'description'   => $coin . ' - BUY'
        ]);

        return $this->portfolioService->create([
            'user_id'       => Auth::user()->id,
            'ticker'        => $coin,
            'price'         => $sellOffer,
            'amount'        => $amount,
            'coin_amount'   => number_format(($amount / $sellOffer), 10, '.', ',')
        ]);
    }

    public function sell(string $coin = 'BTC', float $amount) : bool {

        $buyOffer = (float) $this->getQuotation($coin)['buy'];

        $this->userService->validatePortfolio($amount, $buyOffer, $coin);

        $remainder = 0;
        $originalAmount = $amount;
        foreach (Auth::user()->portfolios->where('ticker', $coin) as $value) {
            $currentAmount = ($buyOffer/$value->price) * $value->amount;

            if ($currentAmount <= $amount) {
                $amount -= $currentAmount;
            }else {
                $remainder = $currentAmount - $amount;
                $amount -= $amount;
                $this->portfolioService->create([
                    'user_id'       => Auth::user()->id,
                    'ticker'        => $coin,
                    'price'         => $value->price,
                    'amount'        => $remainder,
                    'coin_amount'   => number_format(($remainder / $value->price), 10, '.', ',')
                ]);
            }
            $value->delete();

            if ($amount == 0) break;
        }

        $this->transactionService->add([
            'ticker'        => $coin,
            'amount'        => $originalAmount,
            'description'   => $coin . ' - SELL'
        ]);

        if ($remainder > 0)
            $this->transactionService->sub([
                'ticker'        => $coin,
                'amount'        => $remainder,
                'description'   => $coin . ' - BUY'
            ]);

        return true;
    }
}
