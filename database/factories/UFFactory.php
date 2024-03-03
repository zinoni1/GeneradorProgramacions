<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UF>
 */
class UfFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'nom' => $this->faker->word,
            'setmanes' => $this->faker->randomDigit,
            'ordre' => $this->faker->randomDigit,

        ];
    }
}
