<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventStopwatch extends Component
{
     public $selectedEventName;
    public $athlete_name;

    public function FinishStopWatch(int $finalTimeMs, array $lapData)
    {

    }

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.event.stopwatch');
    }
}
