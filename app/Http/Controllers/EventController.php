<?php

namespace App\Http\Controllers;

use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use App\Models\PlayerTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{

    public function StoreTime(Request $request)
{
    $line       = $request->line;
    $start_time = $request->start_time;
    $end_time   = $request->end_time;

    // Cari match yang sedang aktif
    $match = EventMatch::where('status', 1)->first();
    if (!$match) {
        return response()->json([
            'error' => true,
            'message' => 'Tidak ada pertandingan aktif.',
            'data' => null
        ], 404);
    }

    // Cari player berdasarkan line
    $player = EventMatchPlayer::where('event_match_id', $match->id)
        ->where('line', $line)
        ->first();
    if (!$player) {
        return response()->json([
            'error' => true,
            'message' => 'Player tidak ditemukan untuk line ini.',
            'data' => null
        ], 404);
    }

    // Simpan waktu player
    $playerTime = PlayerTime::create([
        'player_id'   => $player->id,
        'start_time'  => $start_time,
        'finish_time' => $end_time,
        'duration'    => null,
    ]);

    // Hitung durasi total
    $times = PlayerTime::where('player_id', $player->id)->get();
    $duration = null;

    if ($times->count() > 0) {
        $firstStart = $times->min('start_time');
        $lastEnd    = $times->max('finish_time');

     if ($firstStart && $lastEnd) {
            // Buat objek DateTime dari string waktu
            $startTime = new \DateTime($firstStart);
            $endTime   = new \DateTime($lastEnd);

            // Ambil timestamp UNIX dari masing-masing objek
            $startTimestamp = $startTime->getTimestamp();
            $endTimestamp   = $endTime->getTimestamp();

            // Hitung selisihnya dalam detik
            $duration = $endTimestamp - $startTimestamp;
            // Format durasi ke dalam format yang diinginkan (HH:MM:SS)
            $duration = gmdate('H:i:s', $duration);
            
        }

        // Update durasi untuk semua record player
        PlayerTime::where('player_id', $player->id)->update([
            'duration' => $duration
        ]);

        // Update di table player
        $player->result_time = $duration;
        $player->save();
    }

    // Response sukses
    return response()->json([
        'error' => false,
        'message' => 'Waktu player berhasil disimpan.',
        'data' => [
            'player_id' => $player->id,
            'line' => $line,
            'start_time' => $start_time,
            'finish_time' => $end_time,
            'duration' => $duration
        ]
    ]);
}

// public function StoreTime(Request $request)
// {
//     $line       = $request->line;
//     $start_time = $request->start_time;
//     $end_time   = $request->end_time;

//     $match = EventMatch::where('status', 1)->first();
//     if (!$match) {
//         return response()->json(['message' => 'No active match found.'], 404);
//     }

//     $player = EventMatchPlayer::where('event_match_id', $match->id)
//         ->where('line', $line)
//         ->first();
//     if (!$player) {
//         return response()->json(['message' => 'Player not found for this line.'], 404);
//     }

//     PlayerTime::create([
//         'player_id'   => $player->id,
//         'start_time'  => $start_time,
//         'finish_time' => $end_time,
//         'duration'    => null,
//     ]);

//     $times = PlayerTime::where('player_id', $player->id)->get();

//     if ($times->count() > 0) {
//         $firstStart = $times->min('start_time');
//         $lastEnd    = $times->max('finish_time');

//         // Hitung durasi
//         $first = \Carbon\Carbon::parse($firstStart);
//         $last  = \Carbon\Carbon::parse($lastEnd);
//         $duration = $last->diff($first)->format('%H:%I:%S');

//         // Update duration untuk semua record (opsional) atau record terakhir saja
//         PlayerTime::where('player_id', $player->id)->update([
//             'duration' => $duration
//         ]);

//         // Simpan juga di table player
//         $player->result_time = $duration;
//         $player->save();
//     }

//     // return redirect()->back();
//     return response()->json(['message' => 'Player time stored successfully.']);
// }

  public function playerTimeStore($line)
{

    $match = EventMatch::where('status', 1)->first();

    if (!$match) {
        return response()->json(['message' => 'No active match found.'], 404);
    }

    $player = EventMatchPlayer::where('event_match_id', $match->id)
                ->where('line', $line)
                ->first();

    if (!$player) {
        return response()->json(['message' => 'Player not found for this line.'], 404);
    }

    $playerTime = PlayerTime::where('player_id', $player->id)->first();

    if (!$playerTime) {
        PlayerTime::create([
            'player_id' => $player->id,
            'start_time' => now(),
            'finish_time' =>  now(),
            'duration' => null,
        ]);
    } else {
        $finishTime = now();
        $startTime = $playerTime->start_time;

        if (!$startTime) {
            $playerTime->start_time = $finishTime;
        } else {
            $duration = $finishTime->diff($startTime)->format('%H:%I:%S');
            $playerTime->finish_time = $finishTime;
            $playerTime->duration = $duration;

            $player->result_time = $duration;
            $player->save();
        }

        $playerTime->save();
    }

    // return response()->json(['message' => 'Player time and result updated successfully.']);
}


}
