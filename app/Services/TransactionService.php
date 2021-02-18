<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService extends Service
{
    public function __construct(Transaction $transaction, UserService $userService)
    {
        $this->modelInstance = $transaction;
        $this->userService = $userService;
    }

    public function add(array $data) : Transaction {
        $data['type'] = 'ADD';

        $transaction = $this->modelInstance->create($data);

        $this->userService->incrementBalance($transaction->user_id, $data['amount']);

        return $transaction;
    }
}
