<?php

use App\Livewire\Admin\AdminEventIndex;
use App\Livewire\AppSettings;
use App\Livewire\Athlete\AthleteIndex;
use App\Livewire\Club\ClubForm;
use App\Livewire\Club\ClubIndex;
use App\Livewire\Club\ClubProfile;
use App\Livewire\Club\ClubRegisterFeeList;
use App\Livewire\Club\ClubWaitingList;
use App\Livewire\Club\HistoryClubRegistrationTransaction;
use App\Livewire\Club\MigrationAthlete;
use App\Livewire\Coach\CoachIndex;
use App\Livewire\Event\EventForm;
use App\Livewire\Event\EventIndex;
use App\Livewire\Event\MyEvent;
use App\Livewire\Event\MyEventAdministration;
use App\Livewire\Facility;
use App\Livewire\LandingEditor;
use App\Livewire\User\Userindex;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
Route::middleware(['auth'])->group(function () {
    Route::middleware(['checkRole:1'])->group(function () {
        Route::get('club/{id}/detail', ClubProfile::class)->name('club.detail');
        Route::get('club/add', ClubForm::class)->name('club.add');
        Route::get('athlete', AthleteIndex::class)->name('athlete');
        Route::get('event', AdminEventIndex::class)->name('admin-event');
        Route::get('athlete-migration',MigrationAthlete::class)->name('migration');
        Route::get('facility', Facility::class)->name('facility');

        Route::get('landing-page-settings', LandingEditor::class)->name('app.setting.landing');
        Route::get('app-settings', AppSettings::class)->name('app.setting');

        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::get('', Userindex::class)->name('user.index');
        });
        Route::get('club-administration', ClubRegisterFeeList::class)->name('club.registerFeeList');
        Route::get('club-administration/pending', ClubRegisterFeeList::class)->name('club.registerFeeList-pending');
        Route::get('club-administration/confirm', ClubRegisterFeeList::class)->name('club.registerFeeList-confirm');
        Route::get('club-administration/history', ClubRegisterFeeList::class)->name('club.registerFeeList-history');
        Route::get('club-administration/{id}/history', HistoryClubRegistrationTransaction::class)->name('club.registerFeeList-history-detail');
        Route::get('club-administration/setting', ClubRegisterFeeList::class)->name('club.registerFeeList-setting');
        Route::group([
            'prefix' => 'club'
        ], function () {
            Route::get('', ClubIndex::class)->name('club.index');
            Route::get('member', ClubIndex::class)->name('club.member');
            Route::get('waiting-list', ClubWaitingList::class)->name('club.waitingList');

        });
        Route::group([
            'prefix' => 'coach'
        ], function () {

            Route::get('', CoachIndex::class)->name('coach.index');

        });


        Volt::route('swimming-category', 'category.swimmingCategory')->name('swimming-category');
        Volt::route('swimming-category{id}/leaderboard', 'swimmingLeaderboard')->name('swimming-leaderboard');
        // CAN BERES
        Volt::route('team/club', 'team.club')->name('team.club');
        Volt::route('team/school', 'team.school')->name('team.school');
        Volt::route('team/nation', 'team.nation')->name('team.nation');
        Volt::route('team/province', 'team.province')->name('team.province');
        Volt::route('team/city', 'team.city')->name('team.city');

        // CAN BERES

        // ATHLETE PROFILE

  Route::get('my-event-administration',MyEventAdministration::class)->name('admin-event-administration');
        Route::get('my-event',MyEvent::class)->name('club.myEvent');
        Route::get('event/add',EventForm::class)->name('event.add');

    });
    });
?>
