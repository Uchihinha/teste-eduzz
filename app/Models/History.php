<?php

namespace App\Models;

use App\Services\CoinService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class History extends BaseModel
{
    protected $table = 'history';

    protected $fillable = [
        'ticker',
        'sell_price',
        'buy_price',
        'created_at'
    ];

    protected $casts = [
        'sell_price'        => 'float',
        'buy_price'         => 'float',
        'created_at'        => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'id',
        'updated_at'
    ];
}
