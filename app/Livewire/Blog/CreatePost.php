<?php

namespace App\Livewire\Blog;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $blogId;   // untuk edit
    public $title, $content, $thumbnail, $status = 1, $oldThumbnail, $slug;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'thumbnail' => 'nullable|image|max:2048',
        'status' => 'boolean',
        'slug' => 'nullable|string|max:255|unique:blogs,slug' // slug opsional tapi unik
    ];

    public $oldSlug;
    public function mount($id = null)
    {
        if ($id) {
            $blog = Blog::findOrFail($id);
            $this->blogId = $blog->id;
            $this->title = $blog->title;
            $this->content = $blog->content;
            $this->status = $blog->status;
            $this->oldThumbnail = $blog->thumbnail;
            $this->slug = $blog->slug;
            $this->oldSlug=$blog->slug;

        }
    }

    public function updatedTitle()
    {
        // Kalau slug kosong, generate otomatis dari title
            $this->slug = Str::slug($this->title);
    }

    public function render()
    {
        return view('livewire.blog.create-post');
    }

    public function store()
    {
        $this->validate();

        // Kalau slug kosong, generate dari title
        $slug = $this->slug ?: Str::slug($this->title);

        $thumbnailPath = $this->oldThumbnail;

        // Jika upload thumbnail baru
        if ($this->thumbnail) {
            // hapus thumbnail lama kalau ada
            if ($this->oldThumbnail && Storage::disk('public')->exists($this->oldThumbnail)) {
                Storage::disk('public')->delete($this->oldThumbnail);
            }
            // simpan thumbnail baru
            $thumbnailPath = $this->thumbnail->store('thumbnails', 'public');
        }

        if ($this->blogId) {
            // update
            $blog = Blog::findOrFail($this->blogId);
            $blog->update([
                'title' => $this->title,
                'content' => $this->content,
                'thumbnail' => $thumbnailPath,
                'slug' => $slug,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Blog berhasil diperbarui.');
        } else {
            // create
            Blog::create([
                'title' => $this->title,
                'content' => $this->content,
                'thumbnail' => $thumbnailPath,
                'slug' => $slug,
                'status' => $this->status,
                'user_id' => auth()->id(),
                'published_at' => now(),
            ]);
            session()->flash('success', 'Blog berhasil ditambahkan.');
        }

        return $this->redirect('/blog', navigate: true);
    }
}
