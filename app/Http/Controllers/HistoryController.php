<?php

namespace App\Http\Controllers;

use App\Services\HistoryService;

class HistoryController extends Controller
{
    public function __construct(HistoryService $historyService)
    {
        $this->serviceInstance = $historyService;
    }

}
