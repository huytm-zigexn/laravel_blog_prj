<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesQuantityCard extends Component
{
    public $categoriesQuantity;

    public function mount()
    {
        $this->categoriesQuantity = Category::count();
    }

    public function render()
    {
        $this->categoriesQuantity = Category::count();
        return view('livewire.categories-quantity-card');
    }
}
