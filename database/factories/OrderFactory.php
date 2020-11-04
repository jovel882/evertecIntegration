<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 100);
        return [
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(config('config.order_status')),
            'quantity' => $quantity,
            'total' => $quantity * config('config.product_price'),
        ];
    }
}
