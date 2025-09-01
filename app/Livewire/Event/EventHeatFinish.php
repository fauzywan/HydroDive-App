<?php

namespace App\Livewire\Event;

use App\Models\EventHeat;
use App\Models\EventMatchPlayer;
use Livewire\Component;

class EventHeatFinish extends Component
{
    public $heat;
    public $players = [];

    public function mount($id)
    {
        $this->heat = EventHeat::find($id);

        $this->players = collect($this->heat->matches)
            ->flatMap(fn($m) => $m->players)
            ->sort(function ($a, $b) {
                // Urutkan berdasarkan result_time, null di bawah
                if (is_null($a->result_time) && is_null($b->result_time)) {
                    return 0;
                }
                if (is_null($a->result_time)) {
                    return 1;
                }
                if (is_null($b->result_time)) {
                    return -1;
                }
                return strcmp($a->result_time, $b->result_time);
            })
            ->values()
            ->map(function ($player, $index) {
                return [
                    'id'           => $player->id,
                    'athlete_name' => $player->athlete->name() ?? '-',
                    'heat'         => $player->match->heat ?? '-',
                    'result_time'  => $player->result_time,
                    'position'     => is_null($player->result_time) ? null : $index + 1,
                ];
            })
            ->toArray();
    }

    public function endHeat()
    {
        foreach ($this->players as $p) {
            
            // EventMatchPlayer::find($p['id'])->update([
            //     'rank'     => $p['position'], // rank = posisi
            // ]);
            // EventMatchPlayer::find($p['id'])->administration->update([
            //     'rank' => $p['position'], // rank = posisi
            // ]);
            $emp = EventMatchPlayer::find($p['id']);

if ($emp) {
    // update rank di EventMatchPlayer
    $emp->update([
        'rank' => $p['position'],
    ]);

    // update rank di administration kalau ada relasi
    if ($emp->administration) {
        $emp->administration->update([
            'rank' => $p['position'],
        ]);
    }
}
        }
        $this->heat->update(['status' =>-1]);
        return $this->redirect("/number/{$this->heat->branch->eventNumber->id}/list-heat");
    }

    public function render()
    {
        return view('livewire.event.event-heat-finish');
    }
}
