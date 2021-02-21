<?php

namespace App\Models;

class Log extends BaseModel
{
    protected $table = 'log';

    protected $fillable = [
        'id',
        'method',
        'request',
        'response',
        'status_code',
        'url',
        'ip'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
