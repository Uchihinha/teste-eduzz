<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PortfolioService extends Service
{
    public function __construct(Portfolio $portfolio)
    {
        $this->modelInstance = $portfolio;
    }

    public function get() : Collection {
        return $this->modelInstance->where('user_id', Auth::user()->id)->get();
    }

}
