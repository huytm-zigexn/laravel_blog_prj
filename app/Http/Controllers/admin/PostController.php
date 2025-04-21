<?php
namespace App\Http\Controllers\admin;

use App\Events\AuthorsPublishPostNotify;
use App\Events\FollowingsPublishPostNotify;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPostCreateValidate;
use App\Http\Requests\AdminPostUpdateValidate;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\AuthorsPublishPost;
use App\Notifications\FollowingsPublishPost;
use Illuminate\Support\Str;
use App\QueryFilters\PostFilter;

class PostController extends Controller
{
    public function index(PostFilter $filters)
    {
        $authors = User::whereIn('role', ['author', 'admin'])
               ->whereHas('posts')
               ->orderBy('name')
               ->get();
        $categories = Category::whereHas('posts')->orderBy('name')->get();
        $tags = Tag::whereHas('posts')->orderBy('name')->get();
        $posts = Post::filter($filters)->with(['user', 'category'])->paginate(10);

        return view('admin.posts.index', compact('posts', 'authors', 'categories', 'tags'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('admin.posts.show', compact('post'));
    }

    public function getCreate()
    {
        $authors = User::whereIn('role', ['author', 'admin'])
               ->orderBy('name')
               ->get();
        $tags = Tag::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories', 'authors', 'tags'));
    }

    public function store(AdminPostCreateValidate $request)
    {
        $thumbnailPath = null;
        
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = 'storage/' . $request->file('thumbnail')->store('thumbnails', 'public');
        }
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;

        while(Post::where('slug', $slug)->exists())
        {
            $slug = $originalSlug . '-' . $counter++;
        }

        $status = $request->status === 'Publish' ? 'published' : 'draft';
        $content = str_replace('../../storage', asset('storage'), $request->content);

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $content,
            'thumbnail' => asset($thumbnailPath),
            'category_id' => $request->category_id,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
            'user_id' => $request->user_id
        ]);

        $post->tags()->sync($request->tags);

        if($status === 'published')
        {
            $authUser = User::findOrFail($request->user_id);
            event(new FollowingsPublishPostNotify([
                'user_id' => $authUser->id,
                'user_name' => $authUser->name,
                'user_avatar' => $authUser->avatar,
                'message' => '<a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has published ' . '<a href="' . route('posts.show', $post->slug) . '"> a new post' . '</a>',
            ]));
            foreach($authUser->followers as $follower)
            {
                $follower->notify(new FollowingsPublishPost($authUser, $post));
            }
            $admin = User::where('role', 'admin')->with('followings')->firstOrFail();
            if(($admin->id !== $authUser->id) && !$admin->followings->contains('id', $authUser->id))
            {
                event(new AuthorsPublishPostNotify([
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'user_avatar' => $authUser->avatar,
                    'message' => 'Author <a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has published ' . '<a href="' . route('posts.show', $post->slug) . '"> a new post' . '</a>',
                ]));
                $admin->notify(new AuthorsPublishPost($authUser, $post));
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function edit(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $categories = Category::orderBy('name')->get();
        $authors = User::whereIn('role', ['author', 'admin'])->get();
        $tags = Tag::whereHas('posts')->orderBy('name')->get();
        $status = ['draft', 'published'];

        return view('admin.posts.edit', compact('categories', 'post', 'status', 'authors', 'tags'));
    }

    public function update(AdminPostUpdateValidate $request, string $slug)
    {   
        $post = Post::where('slug', $slug)->firstOrFail();
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = 'storage/' . $request->file('thumbnail')->store('thumbnails', 'public');
            $post->thumbnail = $thumbnailPath;
        }

        if($request->title !== $post->title)
        {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
    
            while(Post::where('slug', $slug)->exists())
            {
                $slug = $originalSlug . '-' . $counter++;
            }

            $post->slug = $slug;
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->status = $request->status;
        $post->user_id = $request->user_id;

        if($request->status === 'published')
        {
            $post->published_at = now();
            $authUser = User::findOrFail($request->user_id);
            event(new FollowingsPublishPostNotify([
                'user_id' => $authUser->id,
                'user_name' => $authUser->name,
                'user_avatar' => $authUser->avatar,
                'message' => '<a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has published ' . '<a href="' . route('posts.show', $post->slug) . '"> a new post' . '</a>',
            ]));
            foreach ($authUser->followers as $follower) {
                $follower->notify(new FollowingsPublishPost($authUser, $post));
            }
    
            $admin = User::where('role', 'admin')->firstOrFail();
            if (($admin->id !== $authUser->id) && !$admin->followings->contains('id', $authUser->id)) {
                event(new AuthorsPublishPostNotify([
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'user_avatar' => $authUser->avatar,
                    'message' => 'Author <a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has published ' . '<a href="' . route('posts.show', $post->slug) . '"> a new post' . '</a>',
                ]));
                $admin->notify(new AuthorsPublishPost($authUser, $post));
            }
        }

        
        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function delete(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully!');
    }
}


