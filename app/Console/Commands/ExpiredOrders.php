<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expira las ordenes que no se hayan completado.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::getByDiferenceDaysWithCreateAndStates(config('config.expired_days_order'), [
            'CREATED',
        ])->each(function ($order, $key) {
            $order->store([
                'status' => 'REJECTED',
            ]);
        });
    }
}
