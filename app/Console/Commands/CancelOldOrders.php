<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CancelOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $twoMinutesAgo = Carbon::now()->subMinutes(2);

        $affected = DB::table('orders')
            ->where('status', 'На оплату')
            ->where('created_at', '<', $twoMinutesAgo)
            ->update(['status' => 'Отменен']);

        $this->info("Cancelled {$affected} orders.");

        return CommandAlias::SUCCESS;
    }
}
