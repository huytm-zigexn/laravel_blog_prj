<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kblais\QueryFilter\Filterable;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'description'
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = static::generateUniqueSlug($category->name);
        });
    
        // Tạo slug khi cập nhật name (chỉ khi name bị đổi)
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = static::generateUniqueSlug($category->name, $category->id);
            }
        });
    }

    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
