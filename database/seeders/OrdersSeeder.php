<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dispatcher = Order::getEventDispatcher();
        Order::unsetEventDispatcher();
        Order::factory()
            ->count(50)
            ->create();
        Order::setEventDispatcher($dispatcher);
    }
}
