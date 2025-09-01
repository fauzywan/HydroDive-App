<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'no' => $this->faker->numberBetween(1, 999),
            'distance' => $this->faker->randomElement(['50m', '100m', '200m']),
            'style' => $this->faker->randomElement(['freestyle', 'backstroke', 'breaststroke', 'butterfly']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'pool_type' => $this->faker->randomElement(['indoor', 'outdoor']),
            'relay' => $this->faker->boolean,
            'description' => $this->faker->sentence,
        ];
    }
}
