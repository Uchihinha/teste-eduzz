<?php

namespace App\Services;

use App\Models\User;

class UserService extends Service
{
    public function __construct(User $user)
    {
        $this->modelInstance = $user;
    }

    public function incrementBalance(int $id, float $amount) {
        $this->modelInstance->find($id)->increment('balance', $amount);
    }
}
