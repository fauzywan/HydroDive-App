<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\CategoryLeaderboard;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class SwimmingLeaderboard extends Component
{
    use WithPagination;

    public $search = '';

    public $category;
    public function mount($id)
{
    $this->category = Category::find($id);;
}
public function openModal($id)
{
    Flux::modal($id)->show();
}
public function closeModal($id)
{
    Flux::modal($id)->close();
}
    public function render()
    {

        $leaderboards = CategoryLeaderboard::where('category_id',$this->category->id)->with(['athlete', 'category', 'club', 'event'])
            ->when($this->search, function ($query) {
                $query->whereHas('athlete', function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('lastName', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('duration') // urut berdasarkan waktu tercepat
            ->paginate(10);

        return view('livewire.swimming-leaderboard', [
            'leaderboards' => $leaderboards,
        ]);
    }
}
