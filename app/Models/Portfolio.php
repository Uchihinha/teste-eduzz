<?php

namespace App\Models;

use App\Services\CoinService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Portfolio extends BaseModel
{
    use SoftDeletes;

    protected $table = 'portfolio';

    protected $fillable = [
        'user_id',
        'ticker',
        'price',
        'amount',
        'coin_amount'
    ];

    protected $casts = [
        'price'         => 'float',
        'amount'        => 'float',
        'coin_amount'   => 'float',
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H::i:s',
    ];

    protected $appends = [
        'variation',
        'current_amount'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function getVariationAttribute() {
        $currentQuotation = app(CoinService::class)->getQuotation($this->attributes['ticker'])['last'];

        return (float) number_format(($currentQuotation / $this->attributes['price']), 2, '.', ',');
    }

    public function getCurrentAmountAttribute() {
        return (float) number_format(($this->getVariationAttribute() * $this->attributes['amount']), 2, '.', ',');
    }
}
