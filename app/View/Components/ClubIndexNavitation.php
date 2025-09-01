<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClubIndexNavitation extends Component
{
    /**
     * Create a new component instance.
     */
    public $waitingCount;
    public function __construct($waitingCount)
    {
        $this->waitingCount=$waitingCount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.club-index-navitation');
    }
}
