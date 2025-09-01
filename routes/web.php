<?php

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Livewire\Athlete\AthleteForm;
use App\Livewire\Athlete\AthleteProfile;
use App\Livewire\Athlete\GuardianForm;
use App\Livewire\Blog\BlogIndex;
use App\Livewire\Blog\CreatePost;
use App\Livewire\Category\SwimmingCategory;
use App\Livewire\Club\ClubForm;
use App\Livewire\Club\ClubRegister;
use App\Livewire\Coach\CoachForm;
use App\Livewire\Coach\CoachProfile;
use App\Livewire\Event\EventBranchForm;
use App\Livewire\Event\EventDetail;
use App\Livewire\Event\EventForm;
use App\Livewire\Event\EventHeatFinish;
use App\Livewire\Event\EventHistory;
use App\Livewire\Event\EventHistoryDetail;
use App\Livewire\Event\EventIndex;
use App\Livewire\Event\EventMainMenu;
use App\Livewire\Event\EventNumberDetail;
use App\Livewire\Event\EventNumberIndex;
use App\Livewire\Event\EventPartisipan;
use App\Livewire\Event\GroupAgeForm;
use App\Livewire\Event\GroupAgeIndex;
use App\Livewire\Event\MatchTimeIndex;
use App\Livewire\EventSelectPlayer;
use App\Livewire\Match\MatchIndex;
use App\Livewire\MatchPlayMenu;
use App\Livewire\SwimmingLeaderboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

Route::get('/post/{slug}', function () {
    $blog = \App\Models\Blog::where('slug', request()->slug)->firstOrFail();
    return view('blog.show', ['blog' => $blog]);
})->name('blog.show');

Route::get('/blogs', function () {
    $blogs = \App\Models\Blog::all();
    return view('blog.index', ['blogs' => $blogs]);
})->name('blog.all');

Route::get('/', function () {
    $json = Storage::disk('public')->get('landing.json');
    $section = collect(json_decode($json, true));

    return view('welcome', ['section' => $section, 'blogs' => \App\Models\Blog::latest()->take(3)->get()]);

})->name('home');
Route::get('/team', function () {
    return view('userDashboard');
})->name('team');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
/*

Route::get('/dashboard', function () {
    if(auth()->user()->role_id==1){

        return view('dashboard.admin');
    }else{
        if(auth()->user()->role_id==5){
            $athleteCount=\App\Models\athleteClub::where('club_id',auth()->user()->club->id)->where('status',1)->get();
            $coachCount=\App\Models\Coach::where('club_id',auth()->user()->id)->count();
            $kompetisiCount=\App\Models\EventClub::where('club_id',auth()->user()->club->id)->count();
            $dayNow = \Carbon\Carbon::now()->dayOfWeekIso;
            $schedules = \App\Models\ClubSchedule::where('club_id', auth()->user()->club->id)
                ->where('day', $dayNow)
                ->take(5)
                ->get();

            $athletes= $athleteCount->take(5);
            $athletes=$athleteCount->map(function($a){
                return $a->athlete;

            });
            $athleteCount=$athleteCount->count();
            return view('dashboard.club',[
                "athleteCount"=>$athleteCount,
                "coachCount"=>$coachCount,
                "kompetisiCount"=>$kompetisiCount,
                "athletes"=>$athletes,
                "schedules"=>$schedules
            ]);
        }else{

            return view('dashboard.dashboard');
        }
    }
})->middleware(['auth', 'verified'])->name('dashboard');

*/
Route::middleware('guest')->group(function () {
    Route::get('register/club', ClubRegister::class)
    ->name('club.register');
});

Route::middleware(['auth'])->group(function () {
    // ROLE ADMIN - CLUB

    Route::middleware(['checkRole:1,5'])->group(function () {
        Route::get('event/{id}/branch-add',EventBranchForm::class)->name('event.branch-add');
        Route::get('event/{id}/branch-admin-add',EventBranchForm::class)->name('event.branch-add');
        Route::get('swimming-category/{id}/leaderboard', SwimmingLeaderboard::class)->name('swimming-leaderboard');

        Route::get('/categories', SwimmingCategory::class);
        Route::get('event/add',EventForm::class)->name('event.add');
        Route::get('event/{id}/detail', EventDetail::class)->name('event.detail');
        Route::get('event/{event}/edit', EventForm::class)->name('event.edit');
        Route::get('event/history', EventHistory::class)->name('event-history');
        Route::get('history/{year}/{id}/detail',EventHistoryDetail::class)->name('branch.detail');
        Route::get('group-age', GroupAgeIndex::class)->name('group-age');

        Route::get('blog',BlogIndex::class)->name('blog.index');
        Route::get('blog/add',CreatePost::class)->name('blog.add');
        Route::get('blog/{id}/edit',CreatePost::class)->name('blog.edit');
        Route::get('athlete/{id}/profile',AthleteProfile::class)->name('athlete.profile');
        Route::get('athlete/add', AthleteForm::class)->name('athlete.add');
        Route::get('athlete/{id}/edit',  AthleteForm::class)->name('athlete.edit');
        Route::get('club/{id}/edit', ClubForm::class)->name('club.edit');
        Route::get('coach/add', CoachForm::class)->name('coach.add');
        Route::get('club/event', EventIndex::class)->name('club.event');
        Route::get('number/{id}/list',EventNumberIndex::class)->name('number.index');
        Route::get('number/{id}/list-heat',EventNumberIndex::class)->name('number.index');
        Route::get('event/{id}/select-player',EventSelectPlayer::class)->name('event.select-player');
        Route::get('event/{id}/add-player',EventSelectPlayer::class)->name('event.select-player');
        Route::get('event/{id}/delete-player',EventSelectPlayer::class)->name('event.select-player');
        Route::get('number/{id}/match',EventNumberIndex::class)->name('number.match');
        Route::get('number/{id}/detail',EventNumberDetail::class)->name('number.detail-heat');
        Route::get('number/{id}/heat',EventNumberDetail::class)->name('number.detail');
        Route::get('heat/{id}/finish',EventHeatFinish::class)->name('heat.finish');

        Route::get('event/{event}/edit',EventForm::class)->name('event.edit');
        Route::get('branch/{id}/edit',EventBranchForm::class)->name('branch.add');
        Route::get('branch/{id}/detail',EventNumberDetail::class)->name('branch.detail');

        Route::get('club/{id}/event', EventMainMenu::class)->name('event.profile');
        Route::get('/club/{id}/certificate', [ClubController::class, 'downloadCertificate'])->name('club.certificate.download');
        Route::get('/stopwatch', MatchTimeIndex::class)->name('event.matchtime');
        Route::get('/stopwatch/{athlete}/{branch}/show-menu', MatchTimeIndex::class)->name('event.matchtime-menu');

        Route::get('match/{id}/play',MatchPlayMenu::class)->name('match-api.menu');
        Route::get('match/{id}/list',MatchIndex::class)->name('match.index');
        Route::get('match/{id}/player',MatchIndex::class)->name('match.player');
        Route::get('event/{id}/partisipan',EventPartisipan::class)->name('branch.partisipan');
        Route::get("event/{line}/player-times", [EventController::class, 'playerTimeStore']);
        Route::get("player-times", [EventController::class, 'StoreTime'])->name("player-times");

    });
    // ROLE ADMIN - CLUB - COACH
    Route::middleware(['checkRole:1,5,4'])->group(function () {
        Route::get('coach/{id}/profile',CoachProfile::class)->name('coach.profile');
        Route::get('coach/{id}/edit', CoachForm::class)->name('coach.edit');
    });

    // ROLE ADMIN - ATHLETE
    Route::middleware('checkRole:1,3')->group(function () {
        Route::get('guardian/{id}/edit',GuardianForm::class)->name('athlete.guardian-edit');
        Route::get('guardian/{id}/add',GuardianForm::class)->name('athlete.guardian-form');
    });
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


require __DIR__.'/auth.php';
require __DIR__.'/roles/athlete.php';
require __DIR__.'/roles/admin.php';
require __DIR__.'/roles/coach.php';
require __DIR__.'/roles/club.php';
