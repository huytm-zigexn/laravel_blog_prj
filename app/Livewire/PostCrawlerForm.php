<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\PostCrawlerService;

class PostCrawlerForm extends Component
{
    public $url;

    public function crawl()
    {
        $this->validate([
            'url' => 'required|url'
        ]);
        
        $postSlug = app(PostCrawlerService::class)->crawl($this->url);

        if ($postSlug) {
            session()->flash('success', 'Successfully crawled data from: ' . $this->url);
            $this->reset('url');
            
            return redirect(route('admin.posts.show', ['slug' => $postSlug]));
        } else {
            session()->flash('error', 'Failed to crawl data from: ' . $this->url);
        }
    }

    public function render()
    {
        return view('livewire.post-crawler-form');
    }
}

