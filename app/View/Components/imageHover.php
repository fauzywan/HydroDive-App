<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class ImageHover extends Component
{
 public $src;
    public $location;

    public function __construct($src, $location)
    {
        $this->src = $src ? $location . $src : 'storage/default.jpg';
        $this->location = $location;
    }

    public function render(): View|Closure|string
    {
        return view('components.image-hover');
    }
}
