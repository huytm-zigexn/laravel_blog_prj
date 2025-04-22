<?php

namespace App\QueryFilters;

use Kblais\QueryFilter\QueryFilter;

class CategoryFilter extends QueryFilter
{
	public function nameSort($order = 'asc')
	{
		$this->builder->orderBy('name', $order);
	}

	public function createdAtSort($order = 'asc')
	{
		$this->builder->orderBy('created_at', $order);
	}

	public function search($value)
	{
		return $this->builder->where('name', 'like', "%{$value}%");
	}
}
