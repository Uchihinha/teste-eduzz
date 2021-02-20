<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService extends Service
{
    public function __construct(User $user)
    {
        $this->modelInstance = $user;
    }

    public function incrementBalance(float $amount) {
        $this->modelInstance->find(Auth::user()->id)->increment('balance', $amount);
    }

    public function decrementBalance(float $amount) {
        $this->modelInstance->find(Auth::user()->id)->decrement('balance', $amount);
    }

    public function validateBalance(float $requestPrice) {
        if ($requestPrice > Auth::user()->balance) throw new BadRequestHttpException('Insufficient balance');
    }

    public function validatePortfolio(float $requestPrice, float $buyOffer, string $coin) {
        $totalPortolio = app(Portfolio::class)->select(DB::raw("sum((($buyOffer) / price) * amount)"))
        ->where('user_id', Auth::user()->id)
        ->where('ticker', $coin)
        ->get()[0]->sum;

        if ( $totalPortolio < $requestPrice ) throw new BadRequestHttpException('Insufficient investments');
    }
}
