<?php
    // ROLE ADMIN - CLUB

use App\Livewire\Club\ClubSchedule;
use App\Livewire\Coach\CoachLicense;
use App\Livewire\Coach\CoachProfile;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth'])->group(function () {
    Route::middleware('checkRole:4')->group(function () {
        Route::get('coach/profile',CoachProfile::class)->name('coach.profile');
        Route::get('coach/schedule',ClubSchedule::class)->name('coach.schedule');
        Route::get('coach/license',CoachLicense::class)->name('coach.license');

    });
    });
