<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class PostManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $selectedPost;
    public $form = ['title' => '', 'slug' => '', 'excerpt' => '', 'body' => '', 'status' => 'draft'];

    public function getPosts()
    {
        $query = Post::query();
        if ($this->search) { $query->where('title', 'like', "%{$this->search}%"); }
        return $query->latest()->paginate(20);
    }

    public function createPost() { $this->resetForm(); $this->isEditing = false; $this->showModal = true; }

    public function editPost(Post $post)
    {
        $this->selectedPost = $post;
        $this->form = $post->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function savePost()
    {
        $this->validate(['form.title' => 'required', 'form.slug' => 'required|unique:posts,slug,' . ($this->selectedPost?->id ?? '')]);
        if ($this->isEditing) { $this->selectedPost->update($this->form); } else { Post::create($this->form); }
        $this->showModal = false;
        session()->flash('success', 'Post saved successfully.');
    }

    public function deletePost(Post $post) { $post->delete(); session()->flash('success', 'Post deleted.'); }
    public function resetForm() { $this->form = ['title' => '', 'slug' => '', 'excerpt' => '', 'body' => '', 'status' => 'draft']; }

    public function render()
    {
        return view('livewire.admin.post-management', ['posts' => $this->getPosts()])->layout('layouts.admin', ['title' => 'Blog Management']);
    }
}
