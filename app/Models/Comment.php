<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kblais\QueryFilter\Filterable;

class Comment extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'is_allowed'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
