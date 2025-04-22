<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kblais\QueryFilter\Filterable;

class Post extends Model
{
    use HasFactory;
    use Filterable;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
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
            $post->slug = static::generateUniqueSlug($post->title);
        });
    
        // Tạo slug khi cập nhật title (chỉ khi title bị đổi)
        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
