<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

// Pastikan route mengarah ke controller atau closure
Route::post('event/{line}/player-times', [EventController::class, 'playerTimeStore']);
Route::post('player-time', [EventController::class, 'StoreTime']);

// Contoh route user dengan middleware
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('clubs', function () {
    return response()->json([
        ['id' => 1, 'name' => 'Manchester United'],
        ['id' => 2, 'name' => 'Real Madrid'],
        ['id' => 3, 'name' => 'Juventus'],
    ]);
});
