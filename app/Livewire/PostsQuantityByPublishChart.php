<?php

namespace App\Livewire;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;

class PostsQuantityByPublishChart extends Component
{
    public $postPublishWeek;
    public $postPublishMonth;
    public $postPublishYear;

    public function mount()
    {
        $this->postPublishYear = now()->year;
        $this->dispatchChart(); // Gửi lần đầu
    }

    public function render()
    {
        return view('livewire.posts-quantity-by-publish-chart');
    }

    public function updatedPostPublishWeek()
    {
        $this->dispatchChart();
    }

    public function updatedPostPublishMonth()
    {
        $this->dispatchChart();
    }

    public function updatedPostPublishYear()
    {
        $this->dispatchChart();
    }

    public function dispatchChart()
    {
        $views = $this->getData();
        $this->dispatch('updatePostPublishChart', labels: $views->keys(), data: $views->values());
    }

    public function getData()
    {
        $query = Post::query();
        $year = $this->postPublishYear;
        $query->whereYear('published_at', $year);

        if ($this->postPublishMonth) {
            $query->whereMonth('published_at', $this->postPublishMonth);

            if ($this->postPublishWeek) {
                $start = Carbon::create($year, $this->postPublishMonth, 1)->addWeeks($this->postPublishWeek - 1)->startOfWeek();
                $end = (clone $start)->endOfWeek();
                $query->whereBetween('published_at', [$start, $end]);
            }
        }

        return $query->selectRaw('DATE(published_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
    }
}
