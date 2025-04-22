<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\QueryFilters\CommentFilter;

class CommentController extends Controller
{
    public function index(CommentFilter $filters)
    {
        $comments = Comment::filter($filters)->with(['user', 'post'])->latest()->paginate(10);
        $posts = Post::whereHas('comments')->orderBy('title')->get();
        $users = User::whereHas('comments')->orderBy('name')->get();
        return view('admin.comments.index', compact('comments', 'posts', 'users'));
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_allowed = true;
        $comment->save();

        return back()->with('success', 'Comment approved.');
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
