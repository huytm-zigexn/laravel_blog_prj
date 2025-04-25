<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PostsOriginCrawlChart extends Component
{
    public function render()
    {
        $this->dispatchChart(); // Gọi lại mỗi lần render
        return view('livewire.posts-origin-crawl-chart');
    }

    public function dispatchChart()
    {
        $posts = $this->getData();
        $this->dispatch('updatePostsOriginCrawlChart', 
                        labels: $posts->keys()->map(function ($key) {
                            return $key ? 'Crawled' : 'Original';
                        }), 
                        data: $posts->values()
                    );
    }

    public function getData()
    {
        return Post::select('is_crawled', DB::raw('COUNT(*) as count'))
            ->groupBy('is_crawled')
            ->pluck('count', 'is_crawled');
    }
}
