<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class MostPopularCategoryCard extends Component
{
    public $mostPopularCategory;

    public function mount()
    {
        $this->mostPopularCategory = Category::with(['posts' => function ($query) {
                $query->withCount('viewedByUsers');
            }])->get()->map(function ($category) {
                $category->total_views = $category->posts->sum('viewed_by_users_count');
                return $category;
            })->sortByDesc('total_views')->first();
    }

    public function render()
    {
        $this->mostPopularCategory = Category::with(['posts' => function ($query) {
                $query->withCount('viewedByUsers');
            }])->get()->map(function ($category) {
                $category->total_views = $category->posts->sum('viewed_by_users_count');
                return $category;
            })->sortByDesc('total_views')->first();
        return view('livewire.most-popular-category-card');
    }
}
