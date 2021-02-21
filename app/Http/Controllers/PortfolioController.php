<?php

namespace App\Http\Controllers;

use App\Services\PortfolioService;

class PortfolioController extends Controller
{
    public function __construct(PortfolioService $portfolioService)
    {
        $this->middleware('auth');
        $this->serviceInstance = $portfolioService;
    }
}
