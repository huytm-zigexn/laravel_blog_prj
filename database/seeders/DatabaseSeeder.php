<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Media;
use App\Models\Notification as ModelsNotification;
use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users, Categories, Tags, Notifications
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '0974625793',
            'role' => 'admin',
            'password' => bcrypt('admin123'), // hoặc Hash::make('admin123')
        ]);

        Category::factory(5)->create();
        Tag::factory(10)->create();
        // ModelsNotification::factory(20)->create();

        // Seed Posts with Tags, Media, and Media_Post relationship
        Post::factory(20)->create()->each(function ($post) {
            // Attach random tags (1-3)
            $tagIds = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $post->tags()->attach($tagIds);
        });

        // Seed Likes
        Like::factory(50)->create();

        // Seed Post Views
        PostView::factory(100)->create();

        $users = User::pluck('id')->toArray();
        $followPairs = [];

        while (count($followPairs) < 30) {
            $followerId = fake()->randomElement($users);
            $followedId = fake()->randomElement($users);

            if ($followerId === $followedId) {
                continue; // không tự follow chính mình
            }

            $key = $followerId . '-' . $followedId;

            if (!isset($followPairs[$key])) {
                $followPairs[$key] = true;

                Follow::create([
                    'follower_id' => $followerId,
                    'followed_id' => $followedId,
                ]);
            }
        }

        // Seed Comments
        Comment::factory(60)->create();
    }
}
