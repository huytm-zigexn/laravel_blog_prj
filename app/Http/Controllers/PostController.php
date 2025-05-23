<?php

namespace App\Http\Controllers;

use App\Events\AuthorsPublishPostNotify;
use App\Events\FollowingsPublishPostNotify;
use App\Http\Requests\ImageRequestValidate;
use App\Http\Requests\PostRequestValidate;
use App\Http\Requests\PostUpdateRequestValidate;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\AuthorsPublishPost;
use App\Notifications\FollowingsPublishPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published')
                     ->orderBy('published_at', 'desc');
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }
        
        // Kết hợp nhiều tag (AND logic)
        if ($request->has('tags') && !empty($request->tags)) {
            $tagSlugs = $request->tags;
            foreach ($tagSlugs as $tagSlug) {
                $query->whereHas('tags', function ($q) use ($tagSlug) {
                    $q->where('slug', trim($tagSlug));
                });
            }
        }
        $posts = $query->paginate(12)->appends($request->all());
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function mostViewsPosts()
    {
        $posts = Post::where('status', 'published')
             ->withCount('viewedByUsers')
             ->orderByDesc('viewed_by_users_count')
             ->take(5)
             ->get();
        return view('homepage', compact('posts')); 
    }

    
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $relatedPosts = self::relatedPosts($post);
        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function getCreate()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(PostRequestValidate $request)
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

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
            'user_id' => Auth::id()
        ]);

        if($status === 'published')
        {
            $authUser = User::findOrFail(Auth::id());
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

        return redirect()->route('user.show', Auth::id())->with('success', 'Post created successfully');
    }

    public function imgUpload (ImageRequestValidate $request)
    {
        $thumbnailPath = null;
        
        if ($request->hasFile('file')) {
            $thumbnailPath = $request->file('file')->store('thumbnails', 'public');
            return response()->json([
                'location' => asset('storage/' . $thumbnailPath)
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function publish(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->status = 'published';
        $post->save();
        $authUser = User::findOrFail(Auth::id());
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

        $admin = User::where('role', 'admin')->firstOrFail();
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

        return redirect()->back()->with('success', 'Post published successfully');
    }

    public function edit(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $categories = Category::orderBy('name')->get();
        return view('posts.update', compact('categories', 'post'));
    }

    public function update(PostUpdateRequestValidate $request, string $slug)
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
        
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function delete(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->delete();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
    
    private static function relatedPosts($post)
    {
        $relatedPosts = Post::where('status', 'published')
                    ->where('category_id', $post->category_id)
                    ->where('id', '!=', $post->id)
                    ->withCount('viewedByUsers')
                    ->orderByDesc('viewed_by_users_count')
                    ->take(5)
                    ->get();
        return $relatedPosts;
    }
}
