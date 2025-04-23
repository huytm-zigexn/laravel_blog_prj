<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class UsersQuantityFilterChart extends Component
{
    public $userQuantityWeek;
    public $userQuantityMonth;
    public $userQuantityYear;

    public function mount()
    {
        $this->userQuantityYear = now()->year;
        $this->dispatchChart();
    }

    public function render()
    {
        return view('livewire.users-quantity-filter-chart');
    }

    public function updatedUserQuantityWeek()
    {
        $this->dispatchChart();
    }

    public function updatedUserQuantityMonth()
    {
        $this->dispatchChart();
    }

    public function updatedUserQuantityYear()
    {
        $this->dispatchChart();
    }

    public function dispatchChart()
    {
        $users = $this->getData();
        $this->dispatch('updateUsersQuantityFilterChart', labels: $users->keys(), data: $users->values());
    }

    public function getData()
    {
        $query = User::query();
        $year = $this->userQuantityYear;
        $query->whereYear('created_at', $year);

        if ($this->userQuantityMonth) {
            $query->whereMonth('created_at', $this->userQuantityMonth);

            if ($this->userQuantityWeek) {
                $start = Carbon::create($year, $this->userQuantityMonth, 1)->addWeeks($this->userQuantityWeek - 1)->startOfWeek();
                $end = (clone $start)->endOfWeek();
                $query->whereBetween('created_at', [$start, $end]);
            }
        }

        return $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
    }
}
