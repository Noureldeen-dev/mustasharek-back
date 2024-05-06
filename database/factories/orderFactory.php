<?php

namespace Database\Factories;

use App\Models\deliveryMan;
use App\Models\product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\order>
 */
class orderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user' => User::all()->random()->id,
            'product' => product::all()->random()->id,
            'delivery' => deliveryMan::all()->random()->id,

        ];
    }
}
