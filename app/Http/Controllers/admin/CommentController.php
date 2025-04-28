<?php
namespace App\Http\Controllers\admin;

use App\Events\CommentedPostNotify;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserCommentedPost;
use App\QueryFilters\CommentFilter;

class CommentController extends Controller
{
    public function index(CommentFilter $filters)
    {
        $comments = Comment::whereHas('user')->filter($filters)->with(['user', 'post'])->latest()->paginate(10);
        $posts = Post::whereHas('comments')->orderBy('title')->get();
        $users = User::whereHas('comments')->orderBy('name')->get();
        return view('admin.comments.index', compact('comments', 'posts', 'users'));
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $post = Post::findOrFail($comment->post_id);
        $commentedUser = User::findOrFail($comment->user_id);
        $user = User::findOrFail($post->user_id);
        $comment->is_allowed = true;
        $comment->save();

        event(new CommentedPostNotify([
            'user_id' => $commentedUser->id,
            'user_name' => $commentedUser->name,
            'user_avatar' => $commentedUser->avatar,
            'message' => '<a href="' . route('user.show', $commentedUser->id) . '">' . $commentedUser->name . '</a>' . ' has commented on your <a href="' . route('posts.show', $post->slug) . '">' . $post->title . '</a>',
        ]));
        $user->notify(new UserCommentedPost($commentedUser, $post));
        return back()->with('success', 'Comment approved.');
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
