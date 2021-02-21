<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Mail\Notify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendEmail extends Job
{
    protected $transaction;

    protected $to;

    public function __construct($to, $transaction)
    {
        $this->transaction = $transaction;
        $this->to = $to;
    }

    public function handle()
    {
        FacadesMail::to($this->to)->send(new Notify($this->transaction));
    }
}
