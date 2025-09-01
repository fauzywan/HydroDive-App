<?php

use App\Http\Controllers\ClubController;
use App\Livewire\Club\ClubAdministration;
use App\Livewire\Club\ClubAthlete;
use App\Livewire\Club\ClubBilling;
use App\Livewire\Club\ClubCoach;
use App\Livewire\Club\ClubFacility;
use App\Livewire\Club\ClubMembership;
use App\Livewire\Club\ClubMyBill;
use App\Livewire\Club\ClubProfile;
use App\Livewire\Club\ClubSchedule;
use App\Livewire\Club\MigrationAthlete;
use App\Livewire\Event\EventBranchForm;
use App\Livewire\Event\EventBranchIndex;
use App\Livewire\Event\EventForm;
use App\Livewire\Event\EventIndex;
use App\Livewire\Event\EventMainMenu;
use App\Livewire\Event\EventNumberDetail;
use App\Livewire\Event\EventNumberIndex;
use App\Livewire\Event\EventPartisipan;
use App\Livewire\Event\MatchTimeIndex;
use App\Livewire\Event\MyEvent;
use App\Livewire\Event\MyEventAdministration;
use App\Livewire\Match\MatchIndex;
use App\Models\EventNumber;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','checkRole:5'])->group(function () {
        // Route::get('club/my-bill',ClubMyBill::class)->name('club.myBill');
        Route::get('club/my-bill/history',ClubBilling::class)->name('club.myBillHistory');
        Route::get('club/my-bill',ClubBilling::class)->name('club.myBill');
        Route::get('club/administration',ClubAdministration::class)->name('club.administration');
        Route::get('club/athlete-migration',MigrationAthlete::class)->name('club.migration');
        Route::get('club/athlete',ClubAthlete::class)->name('club.athlete');
        Route::get('club/athlete-waiting-list',ClubAthlete::class)->name('club.athleteWaitingList');
        Route::get('club/coach', ClubCoach::class)->name('club.coach');
        Route::get('club/profile',ClubProfile::class)->name('club.profile');
        Route::get('club/membership',ClubMembership::class)->name('club.membership');
        Route::get('club/schedule',ClubSchedule::class)->name('club.schedule');
        Route::get('club/facility',ClubFacility::class)->name('club.facility');

        Route::get('club/my-event-administration',MyEventAdministration::class)->name('club.myEventAdministration');
        Route::get('club/my-event',MyEvent::class)->name('club.myEvent');
        // Route::get('event/{event}/edit',EventForm::class)->name('event.edit');
        // Route::get('event/{id}/branch-add',EventBranchForm::class)->name('event.add');
        // Route::get('branch/{id}/edit',EventBranchForm::class)->name('branch.add');
        // Route::get('branch/{id}/detail',EventNumberDetail::class)->name('branch.detail');
        // Route::get('number/{id}/list',EventNumberIndex::class)->name('number.index');
        // Route::get('number/{id}/list-heat',EventNumberIndex::class)->name('number.index');
        // Route::get('number/{id}/match',EventNumberIndex::class)->name('number.match');
        // Route::get('number/{id}/detail',EventNumberDetail::class)->name('number.detail-heat');
        // Route::get('number/{id}/heat',EventNumberDetail::class)->name('number.detail');
        // Route::get('club/{id}/event', EventMainMenu::class)->name('event.profile');
        // Route::get('/club/{id}/certificate', [ClubController::class, 'downloadCertificate'])->name('club.certificate.download');
        // Route::get('/stopwatch', MatchTimeIndex::class)->name('event.matchtime');
        // Route::get('/stopwatch/{athlete}/{branch}/show-menu', MatchTimeIndex::class)->name('event.matchtime-menu');

        // Route::get('match/{id}/list',MatchIndex::class)->name('match.index');
        // Route::get('match/{id}/player',MatchIndex::class)->name('match.player');
        // Route::get('event/{id}/partisipan',EventPartisipan::class)->name('branch.partisipan');
    });?>
