<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClubTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'is_create' => true,
        ];
    }
}
