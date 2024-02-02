<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Festiu>
 */
class FestiuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data_inici' => $this->faker->date,
            'data_final' => $this->faker->date,
            'tipus' => $this->faker->word
        ];
    }
}
