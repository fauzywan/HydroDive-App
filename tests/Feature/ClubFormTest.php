<?php

use App\Livewire\Athlete\AthleteForm;
use App\Models\Athlete;
use App\Models\Club;
use App\Models\RegistrationFee;
use App\Models\User;
use App\Models\settings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

// TEST CASE 1: Athlete can be created successfully
it('can create an athlete', function () {
    Storage::fake('public');

    $club = Club::factory()->create([
        'nick' => 'ABC',
        'registration_fee' => 100000,
    ]);

    $user = User::factory()->create([
        'role_id' => 5,
        'club_id' => $club->id,
    ]);

    settings::factory()->create(['password_default' => 'password123']);

    $this->actingAs($user);

    $photo = UploadedFile::fake()->image('photo.jpg');

    Livewire::test(AthleteForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('identity_number', '1234567890123456')
        ->set('dob', '2000-01-01')
        ->set('gender', 'male')
        ->set('province', 'Jakarta')
        ->set('city', 'Jakarta')
        ->set('address', 'Jl. Testing No. 1')
        ->set('email', 'john.doe@example.com')
        ->set('phone', '08123456789')
        ->set('nation', 'Indonesia')
        ->set('club_id', 'ABC')
        ->set('photo', $photo)
        ->call('save');

    $this->assertDatabaseHas('athletes', [
        'first_name' => 'John',
        'email' => 'john.doe@example.com',
    ]);

    Storage::disk('public')->assertExists('athlete/' . md5('John') . '.jpg');
});

// TEST CASE 2: Athlete can be updated successfully
it('can update an athlete', function () {
    $club = Club::factory()->create(['nick' => 'DEF']);
    $athlete = Athlete::factory()->create(['club_id' => $club->id, 'email' => 'old@example.com']);
    $user = User::factory()->create(['role_id' => 1]);
    settings::factory()->create(['password_default' => 'password123']);
    $this->actingAs($user);

    Livewire::test(AthleteForm::class, ['id' => $athlete->id])
        ->set('first_name', 'Updated Name')
        ->set('dob', '2000-01-01')
        ->set('phone', '08123456789')
        ->set('gender', 'male')
        ->set('province', 'Jawa Barat')
        ->set('city', 'Bandung')
        ->set('address', 'Jl. Update')
        ->set('email', $athlete->email) // Keep same email
        ->set('club_id', 'DEF')
        ->call('update');

    $this->assertDatabaseHas('athletes', [
        'id' => $athlete->id,
        'first_name' => 'Updated Name',
    ]);
});

// TEST CASE 3: Athlete can be deleted
it('can delete an athlete', function () {
    $athlete = Athlete::factory()->create();
    $user = User::factory()->create(['role_id' => 1]);
    $this->actingAs($user);

    Livewire::test(AthleteForm::class)
        ->set('athleteId', $athlete->id)
        ->call('destroy');

    $this->assertDatabaseMissing('athletes', [
        'id' => $athlete->id,
    ]);
});
