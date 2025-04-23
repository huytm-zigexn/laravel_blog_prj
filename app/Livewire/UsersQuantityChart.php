<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UsersQuantityChart extends Component
{
    public function render()
    {
        $this->dispatchChart(); // Gọi lại mỗi lần render
        return view('livewire.users-quantity-chart');
    }

    public function dispatchChart()
    {
        $usersQuantity = $this->getData();
        $this->dispatch('updateUsersQuantityChart', labels: $usersQuantity->keys(), data: $usersQuantity->values());
    }

    public function getData()
    {
        return User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
    }
}

