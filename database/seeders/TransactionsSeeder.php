<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dispatcher = Order::getEventDispatcher();
        Order::unsetEventDispatcher();
        Transaction::factory()
            ->count(50)
            ->create();
        Order::setEventDispatcher($dispatcher);
    }
}
