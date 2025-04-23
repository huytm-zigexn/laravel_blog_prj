<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostsQuantityCard extends Component
{
    public $postsQuantity;

    public function mount()
    {
        $this->postsQuantity = Post::count();
    }

    public function render()
    {
        $this->postsQuantity = Post::count();
        return view('livewire.posts-quantity-card');
    }
}
