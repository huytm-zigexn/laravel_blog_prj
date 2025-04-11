<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first()?->id,
            'user_id' => $this->faker->boolean(80)
                    ? User::inRandomOrder()->first()?->id
                    : null,
            'content' => $this->faker->sentence,
            'is_allowed' => $this->faker->boolean(80),
        ];
    }
}
