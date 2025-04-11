<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    protected $model = Media::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'file_name' => 'sample.jpg',
            'file_path' => 'uploads/sample.jpg', // Đường dẫn cố định
            'mime_type' => 'image/jpeg',
            'file_size' => 123456, // Bạn có thể đặt 1 số cụ thể nếu muốn
        ];
    }
}
