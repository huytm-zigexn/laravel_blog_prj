<?php

namespace App\Http\Controllers;

use App\Events\LikedPostNotify;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserLikedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $user = User::where('id', $post->user_id)->firstOrFail();
        $authUser = Auth::user();
        $result = $authUser->likedPosts()->toggle($post->id);
        if (count($result['attached']) > 0) {
            $message = 'Liked ' . $post->title;
            event(new LikedPostNotify([
                'user_id' => $authUser->id,
                'user_name' => $authUser->name,
                'user_avatar' => $authUser->avatar,
                'message' => '<a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has liked your ' . '<a href="' . route('posts.show', $post->slug) . '">' . $post->title . '</a>' . '!',
            ]));
            $user->notify(new UserLikedPost($authUser, $post));
        } elseif (count($result['detached']) > 0) {
            $message = 'Unliked ' . $post->title;
        } else {
            $message = 'Nothing changes.';
        }
        return redirect()->back()->with('success', $message);
    }
}
