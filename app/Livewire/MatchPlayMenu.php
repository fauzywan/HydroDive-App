<?php
namespace App\Livewire;

use App\Models\CategoryLeaderboard;
use App\Models\EventHeat;
use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use App\Models\PlayerTime;
use Flux\Flux;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MatchPlayMenu extends Component
{
    public $navActive = 1;
    public $formType=1;
    public $navigations = [
        ['no' => 1, 'name' => 'User'],
        ['no' => 2, 'name' => 'Event Detail'],
    ];

    public $incomingData = [];
    public $eventDetail = [];
    public $event;
    public $heat;
    public $player;
    public $match;
    public function loadData()
    {

$this->player = $this->match->player->map(function ($p) {
    return ([
        'name' => $p->athlete->name() ?? '',
        'id' => $p->id,
        'time' => $p->result_time,
        'rank' => $p->rank,
        'line' => $p->line,
    ]);
});
    }
    public function mount($id)
    {
        $this->match=EventMatch::find($id);
        $this->heat=$this->match->Heat;


        $this->loadData();

        $this->eventDetail = [
            'name' => 'Kejuaraan Nasional Renang 2025',
            'date' => '2025-08-04',
            'location' => 'Kolam Renang Senayan, Jakarta',
            'start_event' => '10:00:00',
            'end_event' => '10:30:00',
            'description' => 'Kompetisi tingkat nasional dengan berbagai kategori umur dan gaya renang.'
        ];

        $this->eventDetail =   $this->heat->event;
    }

    public function ResetData($id)
    {
        if (EventMatchPlayer::whereKey($id)->exists()) {
            EventMatchPlayer::find($id)->update(['result_time' => null]);
            $line=EventMatchPlayer::find($id)->line;

    if (PlayerTime::where('player_id', $id)->exists()) {
        PlayerTime::where('player_id', $id)->delete();
        $this->loadData();
        session()->flash('message', "Catatan waktu line $line di reset.");
    }
    }
    }

    public function goBack()
    {
        $eventId=$this->heat->event->id;
        return $this->redirect("/event/$eventId/detail",navigate: true);
    }
    public function show($no)
    {
        $this->navActive = $no;
    }
public function pushToApi($line)
{
    $start =now();
    $end   =now();
    // Kirim data via GET query string
    return redirect()->route('player-times', [
        'line'       => $line,
        'start_time' => $start,
        'end_time'   => $end
    ]);

    // try {
    //     $response = Http::post(url("/event/{$line}/player-times"));

    //     if ($response->successful()) {
    //         $this->loadDataFromApi();

    //         session()->flash('message', 'Waktu berhasil disimpan!');
    //     } else {
    //         session()->flash('error', $response->json('message') ?? 'Gagal menyimpan waktu.');
    //     }
    // } catch (\Exception $e) {
    //     session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    // }
}

    public function finishEvent()
    {
        // $id=$this->heat->id;
        // return $this->redirect("/heat/$id/finish");
        foreach ($this->player as $p) {
            EventMatchPlayer::find($p['id'])->update([
                'rank'     => $p['rank'], // rank = posisi
            ]);
             if ($p['time']) {
                $player= EventMatchPlayer::find($p['id']);
                $leaderboardEntry = CategoryLeaderboard::where('category_id', $player->category_id)
                    ->orderBy('duration', 'asc')
                    ->first();

                $isFaster = false;

                if (!$leaderboardEntry) {
                    // Belum ada leaderboard → otomatis masuk
                    $isFaster = true;
                } else {
                    // Bandingkan durasi (lebih kecil = lebih cepat)
                    if (strtotime($player->result_time) < strtotime($leaderboardEntry->duration)) {
                        $isFaster = true;
                    }
                }

                if ($isFaster) {
                    CategoryLeaderboard::create([
                        'category_id'            => $player->category_id,
                        'event_match_player_id'  => $player->id,
                        'athlete_id'             => $player->athlete_id,
                        'club_id'                => $player->administration->club_id,
                        'event_id'               => $player->administration->event_id,
                        'duration'               => $player->result_time,
                    ]);
                }
                }
        }

        if($this->heat->is_final){

            $this->heat->update(['status' =>-1]);
        }
        $this->match->update(['status' =>0]);
        return $this->goBack();
    }
    public function finish()
    {
        Flux::modal('finish-modal')->show();
    }

    public function render()
    {
        return view('livewire.match-play-menu');
    }
        public function addAthlete()
    {
        $id=$this->match->id;
        return $this->redirect("/event/$id/add-player",navigate:true);
    }
}
