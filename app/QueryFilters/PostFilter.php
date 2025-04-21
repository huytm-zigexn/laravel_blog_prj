<?php

namespace App\QueryFilters;

use Illuminate\Support\Facades\Log;
use Kblais\QueryFilter\QueryFilter;

class PostFilter extends QueryFilter
{
	public function titleSort($order = 'asc')
    {
        return $this->builder->orderBy('title', $order);
    }

	public function publishDateSort($order = 'asc')
    {
        return $this->builder->orderBy('published_at', $order);
    }

	public function status($status)
	{
		return $this->builder->where('status', $status);
	}

	public function categoryId($category_id)
	{
		return $this->builder->where('category_id', $category_id);
	}

	public function tagIds($tagIds)
	{
		return $this->builder->whereHas('tags', function ($query) use ($tagIds) {
			$query->whereIn('tags.id', (array) $tagIds);
		});
	}


	public function filterUserId($user_id)
	{
		return $this->builder->where('user_id', $user_id);
	}

	public function search($value)
	{
		return $this->builder->where(function ($query) use ($value) {
			$query->where('title', 'like', "%{$value}%");	
		});
	}
}
