<?php

namespace App\Http\Controllers;

use App\Events\CommentedPostNotify;
use App\Http\Requests\CommentRequestValidate;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserCommentedPost;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store($slug, CommentRequestValidate $request)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $user = User::findOrFail($post->user_id);
        $admin = User::where('role', 'admin')->firstOrFail();
        $authUser = Auth::user();

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_allowed' => 0
        ]);
        event(new CommentedPostNotify([
            'user_id' => $authUser->id,
            'user_name' => $authUser->name,
            'user_avatar' => $authUser->avatar,
            'message' => '<a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has commented ' . $user->name . "'s " . '<a href="' . route('posts.show', $post->slug) . '">' . $post->title . '</a>',
        ]));
        $admin->notify(new UserCommentedPost($authUser, $post));

        return redirect()->route('posts.show', $slug)->with('success', 'Commented successfully!');
    }
}
