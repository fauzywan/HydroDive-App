<?php
namespace Database\Factories;

use App\Models\ClubType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'nick' => strtoupper($this->faker->lexify('???')),
            'owner' => $this->faker->name,
            'owner_photo' => 'default.png',
            'address' => $this->faker->address,
            'hoc' => 1,
            'homebase' => $this->faker->city,
            'pool_status' => '1',
            'type_id' => ClubType::factory(),
            'notarial_deed' => '',
            'registration_link' => '',
        ];
    }
}
