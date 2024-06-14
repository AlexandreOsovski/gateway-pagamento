<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckPurchaseStatus extends Command
{
    protected $signature = 'purchase:check-purchase-status';
    protected $description = 'Check and cancel purchases with "waiting" status after two hours';

    public function handle()
    {
    }
}
