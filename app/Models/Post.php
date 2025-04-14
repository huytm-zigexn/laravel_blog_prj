<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_crawled',
        'source_url',
        'source_name',
        'crawled_at',
        'original_id',
        'user_id',
        'category_id',
        'status',
        'published_at'
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);

            // Kiểm tra slug trùng lặp
            $original = $post->slug;
            $count = 1;
            while (Post::where('slug', $post->slug)->exists()) {
                $post->slug = $original . '-' . $count++;
            }
        });
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function medias()
    {
        return $this->belongsToMany(Media::class, 'media_post', 'post_id', 'media_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function viewedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_views')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
