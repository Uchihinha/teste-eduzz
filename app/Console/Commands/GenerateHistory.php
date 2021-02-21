<?php

namespace App\Console\Commands;

use App\Services\CoinService;
use App\Services\HistoryService;
use Illuminate\Console\Command;

class GenerateHistory extends Command
{
    protected $signature = 'generateHistory';

    protected $description = 'Generate a history for bitcoin prices, both buying and selling';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting...');

        $quotation = app(CoinService::class)->getQuotation();

        app(HistoryService::class)->create([
            'ticker'        => 'BTC',
            'sell_price'    => $quotation['sell'],
            'buy_price'     => $quotation['buy'],
        ]);

        $this->info('Finishing...');
    }
}
