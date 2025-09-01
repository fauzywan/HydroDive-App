<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Athlete')]
class Athlete extends Component
{
public $modalText="Add";
public $modalSubText="Add Athlete Data ";
public $step=1;

#[\Livewire\Attributes\Computed]
public function orders()
{
    return Athlete::query()
        ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
        ->paginate(5);

}
public function render()
    {
        return view('livewire.athlete');
    }
}



