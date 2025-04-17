<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

function hasLiked(Post $post)
{

    return Like::where('post_id', $post->id)
            ->where('user_id', Auth::id())->exists();
}

function notReader($user)
{
    return $user && $user->role !== 'reader';
}