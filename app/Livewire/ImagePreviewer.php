<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ImagePreviewer extends Component
{
    public $photo;
    use WithFileUploads;


    // Menerima event dari CreateItem
    protected $listeners = ['photoUpdated' => 'updatePhoto'];

    public function updatePhoto($photo)
    {
        $this->photo = $photo;
    }

    public function render()
    {
        return view('livewire.image-previewer');
    }
}
