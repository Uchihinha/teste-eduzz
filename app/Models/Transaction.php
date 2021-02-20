<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use SoftDeletes;

    protected $table = 'transaction';

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'coin_amount',
        'type',
        'ticker'
    ];

    protected $casts = [
        'amount'            => 'float',
        'coin_amount'       => 'float',
        'created_at'        => 'datetime:Y-m-d H:i:s',
        'updated_at'        => 'datetime:Y-m-d H::i:s',
    ];

}
