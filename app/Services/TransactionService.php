<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TransactionService extends Service
{
    public function __construct(Transaction $transaction, UserService $userService)
    {
        $this->modelInstance = $transaction;
        $this->userService = $userService;
    }

    public function add(array $data) : Transaction {
        $data['type'] = 'ADD';
        $data['user_id'] = Auth::user()->id;

        $transaction = $this->modelInstance->create($data);

        $this->userService->incrementBalance($data['amount']);

        return $transaction;
    }

    public function sub(array $data) : Transaction {
        $data['type'] = 'SUB';
        $data['user_id'] = Auth::user()->id;

        $transaction = $this->modelInstance->create($data);

        $this->userService->decrementBalance($data['amount']);

        return $transaction;
    }

    public function getResume($days) : Collection {
        $data = $this->modelInstance->where('created_at', '>', Carbon::now()->subDays($days)->format('Y-m-d H:i:s'))->get();

        return $data;
    }
}
