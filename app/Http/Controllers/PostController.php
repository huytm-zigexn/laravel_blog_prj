<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published')
                     ->with('medias')
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
