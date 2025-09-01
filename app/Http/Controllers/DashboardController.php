<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use App\Models\athleteClub;
use App\Models\Club;
use App\Models\Coach;
use App\Models\EventClub;
use App\Models\ClubSchedule;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        if ($user->role_id == 1) {
            $data['event_berlangsung'] = Event::where('status', 1)->get();
            $data['club_count'] =  Club::where('id','!=', 1)->count();
            $data['coach_count'] =Event::count();
            $data['athlete_count'] =Athlete::count();
            $data['athletes'] =Athlete::limit(5)->get();

            return view('dashboard.admin',$data);
        } else if ($user->role_id == 5) {
            if (!$user->club) {
                return view('dashboard.dashboard')->with('error', 'Data klub tidak ditemukan.');
            }

            $athleteCountQuery = athleteClub::where('club_id', $user->club->id)
                                            ->where('status', 1);
            $athleteCount = $athleteCountQuery->count();

            $athletes = $athleteCountQuery->with('athlete')->take(5)->get()->map(function($ac) {
                return $ac->athlete;
            });

            $coachCount = Coach::where('club_id', $user->club->id)->count();

            $kompetisiCount = EventClub::where('club_id', $user->club->id)->count();

            $dayNow = Carbon::now()->dayOfWeekIso;
            $schedules = ClubSchedule::where('club_id', $user->club->id)
                                    ->where('day', $dayNow)
                                    ->take(5)
                                    ->get();

            return view('dashboard.club', [
                "athleteCount" => $athleteCount,
                "coachCount" => $coachCount,
                "kompetisiCount" => $kompetisiCount,
                "athletes" => $athletes,
                "schedules" => $schedules
            ]);
        } else {
            $a=auth()->user();
            if(a->role_id==3 && $a->athlete==null){
                User::find($a->id)->delete();
            }
            return view('dashboard.dashboard');
        }
    }
}
