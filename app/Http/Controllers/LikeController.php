<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        Auth::user()->likedPosts()->toggle($post->id);
        return redirect()->back();
    }
}
