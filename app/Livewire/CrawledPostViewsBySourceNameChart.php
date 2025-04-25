<?php

namespace App\Livewire;

use App\Models\PostView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CrawledPostViewsBySourceNameChart extends Component
{
    public $crawledPostViewWeek;
    public $crawledPostViewMonth;
    public $crawledPostViewYear;

    public function mount()
    {
        $this->crawledPostViewYear = now()->year;
        $this->dispatchChart(); // Gửi lần đầu
    }

    public function render()
    {
        return view('livewire.crawled-post-views-by-source-name-chart');
    }

    public function updatedCrawledPostViewWeek()
    {
        $this->dispatchChart();
    }

    public function updatedCrawledPostViewMonth()
    {
        $this->dispatchChart();
    }

    public function updatedCrawledPostViewYear()
    {
        $this->dispatchChart();
    }

    public function dispatchChart()
    {
        $views = $this->getData();
        $this->dispatch('updateCrawledPostViewsChart', chartData: $views);
    }

    public function getData()
    {
        $year = $this->crawledPostViewYear;

        $query = DB::table('post_views')
            ->join('posts', 'post_views.post_id', '=', 'posts.id')
            ->where('posts.is_crawled', true)
            ->whereYear('post_views.viewed_at', $year);

        if ($this->crawledPostViewMonth) {
            $query->whereMonth('post_views.viewed_at', $this->crawledPostViewMonth);

            if ($this->crawledPostViewWeek) {
                $start = Carbon::create($year, $this->crawledPostViewMonth, 1)
                    ->addWeeks($this->crawledPostViewWeek - 1)
                    ->startOfWeek();
                $end = (clone $start)->endOfWeek();

                $query->whereBetween('post_views.viewed_at', [$start, $end]);
            }
        }

        return $query->selectRaw('DATE(post_views.viewed_at) as date, posts.source_name, COUNT(*) as view_count')
                ->groupBy('date', 'posts.source_name')
                ->orderBy('date')
                ->get()
                ->groupBy('date')
                ->map(function ($items) {
                    return $items->pluck('view_count', 'source_name');
                });
    }
}
