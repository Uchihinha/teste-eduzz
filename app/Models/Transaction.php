<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transaction';

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
        'ticker'
    ];

}
