<?php

namespace App\QueryFilters;

use Kblais\QueryFilter\QueryFilter;

class CommentFilter extends QueryFilter
{
	public function postId($post_id)
	{
		$this->builder->where('post_id', $post_id);
	}

	public function userId($user_id)
	{
		$this->builder->where('user_id', $user_id);
	}

	public function isAllowed($is_allowed)
	{
		$this->builder->where('is_allowed', $is_allowed);
	}
}
