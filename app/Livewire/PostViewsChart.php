<?php
namespace App\Livewire;

use App\Models\PostView;
use Carbon\Carbon;
use Livewire\Component;

class PostViewsChart extends Component
{
    public $postViewWeek;
    public $postViewMonth;
    public $postViewYear;

    public function mount()
    {
        $this->postViewYear = now()->year;
        $this->dispatchChart(); // Gửi lần đầu
    }

    public function render()
    {
        return view('livewire.post-views-chart');
    }

    public function updatedPostViewWeek()
    {
        $this->dispatchChart();
    }

    public function updatedPostViewMonth()
    {
        $this->dispatchChart();
    }

    public function updatedPostViewYear()
    {
        $this->dispatchChart();
    }

    public function dispatchChart()
    {
        $views = $this->getData();
        $this->dispatch('updatePostViewsChart', labels: $views->keys(), data: $views->values());
    }

    public function getData()
    {
        $query = PostView::query();
        $year = $this->postViewYear;
        $query->whereYear('viewed_at', $year);

        if ($this->postViewMonth) {
            $query->whereMonth('viewed_at', $this->postViewMonth);

            if ($this->postViewWeek) {
                $start = Carbon::create($year, $this->postViewMonth, 1)->addWeeks($this->postViewWeek - 1)->startOfWeek();
                $end = (clone $start)->endOfWeek();
                $query->whereBetween('viewed_at', [$start, $end]);
            }
        }

        return $query->selectRaw('DATE(viewed_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
    }
}
