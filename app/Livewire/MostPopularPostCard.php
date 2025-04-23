<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class MostPopularPostCard extends Component
{
    public $mostPopularPost;

    public function mount()
    {
        $this->mostPopularPost = Post::withCount(['viewedByUsers', 'comments', 'likedByUsers'])
                        ->orderByDesc('viewed_by_users_count')
                        ->orderByDesc('comments_count')
                        ->orderByDesc('liked_by_users_count')
                        ->first();
    }

    public function render()
    {
        $this->mostPopularPost = Post::withCount(['viewedByUsers', 'comments', 'likedByUsers'])
                        ->orderByDesc('viewed_by_users_count')
                        ->orderByDesc('comments_count')
                        ->orderByDesc('liked_by_users_count')
                        ->first();
        return view('livewire.most-popular-post-card');
    }
}
