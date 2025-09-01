<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class badgeHref extends Component
{
    /**
     * Create a new component instance.
     */
    public string $href;
     public string $color;
    public function __construct($color="blue",$href="#")
    {
        $this->href = $href;
        $this->color = $color;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge-href');
    }
}
