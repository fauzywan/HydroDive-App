<?php

namespace Database\Factories;

use App\Livewire\Club\ClubAthlete;
use App\Models\athleteClub;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Athlete>
 */
class AthleteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->optional()->lastName,
            'identity_number' => $this->faker->unique()->numerify('################'),
            'dob' => $this->faker->date('Y-m-d', '2005-01-01'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'province' => $this->faker->state,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'photo' => "",
            'nation' => 'Indonesia',
            'type' => $this->faker->randomElement(['regular', 'vip']),
            'club_id' =>1,
            'school' =>"",
            'status' =>0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
}
public function configure()
{
    return $this->afterCreating(function ($athlete) {
        User::create([
            'name' => $athlete->first_name." ".$athlete->last_name,
            'role_id' => 3,
            'email' => $athlete->email,
            'password' => bcrypt('123'),
        ]);
    });
}
}
