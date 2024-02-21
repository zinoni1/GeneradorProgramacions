<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UF>
 */
class UFFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            nom => $this->faker->word,
            num_setmanes => $this->faker->randomDigit,
            ordre => $this->faker->randomDigit,
        ];
    }
}
