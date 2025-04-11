<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'media_post', 'media_id', 'post_id');
    }
}
