<?php

namespace Database\Seeders;

use App\Models\TransactionState;
use Illuminate\Database\Seeder;

class TransactionStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dispatcher = TransactionState::getEventDispatcher();
        TransactionState::unsetEventDispatcher();
        TransactionState::factory()
            ->count(50)
            ->create();
        TransactionState::setEventDispatcher($dispatcher);
    }
}
