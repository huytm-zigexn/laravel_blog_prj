<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kblais\QueryFilter\Filterable;

class Tag extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'description'
    ];

    protected static function booted()
    {
        static::creating(function ($tag) {
            $tag->slug = static::generateUniqueSlug($tag->name);
        });
    
        // Tạo slug khi cập nhật name (chỉ khi name bị đổi)
        static::updating(function ($tag) {
            if ($tag->isDirty('name')) {
                $tag->slug = static::generateUniqueSlug($tag->name, $tag->id);
            }
        });
    }

    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (
            Tag::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }
}
