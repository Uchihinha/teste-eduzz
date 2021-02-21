<?php

namespace App\Services;

use App\Models\History;

class HistoryService extends Service
{
    public function __construct(History $history)
    {
        $this->modelInstance = $history;
    }

}
