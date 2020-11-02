<?php

// /** @var \Illuminate\Database\Eloquent\Factory $factory */

// use App\Models\TransactionState;
// use Faker\Generator as Faker;

// $factory->define(TransactionState::class, function (Faker $faker) {
//     return [
//         "transaction_id" => \App\Models\Transaction::inRandomOrder()->first()->id,
//         "status" => $faker->randomElement(config('config.transaction_status')),
//         "data" => "{}",
//     ];
// });


namespace Database\Factories;

use App\Models\TransactionState;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionStateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransactionState::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'transaction_id' => Transaction::factory(),
            'status' => $this->faker->randomElement(config('config.transaction_status')),
            'data' => '{}',
        ];
    }
}
