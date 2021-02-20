<?php

namespace App\Http\Controllers;

use App\Services\PortfolioService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function __construct(PortfolioService $portfolioService)
    {
        $this->middleware('auth');
        $this->serviceInstance = $portfolioService;
    }

    public function get() {
        return $this->serviceInstance->get();
    }
}
