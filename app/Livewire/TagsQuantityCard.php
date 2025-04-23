<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;

class TagsQuantityCard extends Component
{
    public $tagsQuantity;

    public function mount()
    {
        $this->tagsQuantity = Tag::count();
    }

    public function render()
    {
        $this->tagsQuantity = Tag::count();
        return view('livewire.tags-quantity-card');
    }
}
