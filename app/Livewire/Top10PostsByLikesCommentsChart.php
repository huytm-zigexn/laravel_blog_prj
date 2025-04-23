<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Top10PostsByLikesCommentsChart extends Component
{
    public $likes, $comments, $titles;

    public function render()
    {
        $this->dispatchChart();
        return view('livewire.top10-posts-by-likes-comments-chart');
    }

    public function dispatchChart()
    {
        $posts = $this->getData();
        $this->dispatch('updateTop10PostsChart', titles: $posts->pluck('title'), likes: $posts->pluck('liked_by_users_count'), comments: $posts->pluck('comments_count'));
    }

    public function getData()
    {
        return Post::withCount(['comments', 'likedByUsers'])
            ->where('status', 'published')
            ->whereHas('comments')
            ->whereHas('likedByUsers')
            ->orderByDesc('liked_by_users_count')
            ->take(10)
            ->get();
    }
}
