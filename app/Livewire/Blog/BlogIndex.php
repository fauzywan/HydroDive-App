<?php

namespace App\Livewire\Blog;

use App\Models\Blog;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $blogSelected;
    public function confirmDelete($id)
    {
        $this->blogSelected = Blog::findOrFail($id);
        Flux::modal('delete-modal')->show();
    }
    public function delete()
    {
        if ($this->blogSelected) {
            $this->blogSelected->delete();
            Flux::modal('delete-modal')->close();
            session()->flash('message', 'Blog berhasil dihapus.');
        } else {
            session()->flash('error', 'Blog tidak ditemukan.');
        }
    }
    public function render()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('livewire.blog.blog-index', compact('blogs'));
    }
}
