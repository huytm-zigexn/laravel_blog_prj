<?php

namespace App\QueryFilters;

use Kblais\QueryFilter\QueryFilter;

class UserFilter extends QueryFilter
{
	public function nameSort($order = 'asc')
    {
        return $this->builder->orderBy('name', $order);
    }

	public function joinDateSort($order = 'asc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

	public function role($role)
	{
		return $this->builder->where('role', $role);
	}

	public function search($value)
	{
		return $this->builder->where(function ($query) use ($value) {
			$query->where('name', 'like', "%{$value}%")
				->orWhere('email', 'like', "%{$value}%");
		});
	}
}
