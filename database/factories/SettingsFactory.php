<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SettingsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'password_default' => '123456',
            'registration_fee' => 100000,
            'data_per_page' => 10,
        ];
    }
}
