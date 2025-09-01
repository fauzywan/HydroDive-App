<?php

use App\Livewire\Athlete\AthleteGuardian;
use App\Livewire\Athlete\AthleteMyEvent;
use App\Livewire\Athlete\AthleteMyMatch;
use App\Livewire\Athlete\AthleteProfile;
use App\Livewire\Athlete\GuardianForm;
use App\Livewire\Athlete\ParentAthleteProfile;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth'])->group(function () {
    Route::middleware('checkRole:2')->group(function () {

        Route::get('my-athlete',ParentAthleteProfile::class)->name('parent-athlete.profile');
    });
    Route::middleware('checkRole:3')->group(function () {
        Route::get('profile',AthleteProfile::class)->name('athlete.profile');
        Route::get('guardian/add',GuardianForm::class)->name('athlete.guardian-add');
        Route::get('guardian/{id}/edit',GuardianForm::class)->name('athlete.guardian-add');
        Route::get('guardian',AthleteGuardian::class)->name('athlete.guardians');
        Route::get('my-event',AthleteMyEvent::class)->name('athlete.my-event');
        Route::get('my-club',AthleteMyEvent::class)->name('athlete.my-club');
        Route::get('my-match',AthleteMyMatch::class)->name('athlete.my-match');

    });
    });
