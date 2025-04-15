<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequestValidate;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store($slug, CommentRequestValidate $request)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_allowed' => 0
        ]);

        return redirect()->route('posts.show', $slug)->with('success', 'Commented successfully!');
    }
}
