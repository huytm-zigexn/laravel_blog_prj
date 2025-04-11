<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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
