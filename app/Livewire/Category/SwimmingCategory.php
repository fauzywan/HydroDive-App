<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SwimmingCategory extends Component
{

    use \Livewire\WithPagination;
    public function trophy($id)
    {
        return $this->redirect("swimming-category/{$id}/leaderboard",navigate: true);
    }
    public function render()
    {
        return view('livewire.category.swimming-category',['swimmingCategory'=>Category::paginate(10)]);
    }

    public function refreshInput()
    {
        $this->dispatch('refreshInput');
    }
    public function edit($id)
    {
        $this->dispatch('editModal',$id);
    }
    public function delete($id)
    {
        $this->dispatch('deleteModal',$id);
    }
}
