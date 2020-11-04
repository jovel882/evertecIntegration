<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'uuid' => $this->faker->uuid,
            'current_status' => $this->faker->randomElement(config('config.transaction_status')),
            'gateway' => $this->faker->randomElement(config('config.gateways')),
        ];
    }
}
