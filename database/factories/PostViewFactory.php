<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostView>
 */
class PostViewFactory extends Factory
{
    protected $model = PostView::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first()?->id,
            'user_id' => rand(0, 1) ? User::inRandomOrder()->first()?->id : null,
            'ip_address' => $this->faker->ipv4,
            'viewed_at' => now()->subMinutes(rand(1, 1000)),
        ];
    }

}
