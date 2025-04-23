<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
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

function isAdmin($user)
{
    return $user && $user->role === 'admin';
}

function queryAscDesc($key)
{
    $query = request()->all();
    if($key)
    {
        $query[$key] = request($key) === 'asc' ? 'desc' : 'asc';
    }
    return $query;
}

function createMonthName($m)
{
    Carbon::create()->month($m)->format('F');
}