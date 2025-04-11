<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(5, true),
            'is_crawled' => false,
            'source_url' => null,
            'source_name' => null,
            'crawled_at' => null,
            'original_id' => null,
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? null,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => now(),
        ];
    }
}
