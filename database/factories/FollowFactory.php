<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    protected $model = Follow::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $followerId = User::inRandomOrder()->value('id');

        // Lấy tất cả user_id khác follower_id
        $followedId = User::where('id', '!=', $followerId)
            ->inRandomOrder()
            ->pluck('id')
            ->first();

        return [
            'follower_id' => $followerId,
            'followed_id' => $followedId,
        ];
    }
}
