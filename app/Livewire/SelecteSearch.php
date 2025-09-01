<?php

namespace App\Livewire;

use Livewire\Component;

class SelecteSearch extends Component
{
    public function render()
    {
        return view('livewire.selecte-search',[
            'clubs' => \App\Models\Club::all(),
        ]);
    }
}
