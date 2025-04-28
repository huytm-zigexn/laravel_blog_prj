<?php
namespace App\Jobs;

use App\Models\User;
use App\Models\Post;
use App\Mail\PostSummaryMail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAuthorMonthlyPostSummary implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithQueue;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Lấy các bài viết của author trong tháng
        $posts = Post::where('user_id', $this->user->id)
                    ->whereMonth('published_at', now()->month)
                    ->get();

        // Tính toán likes, views, comments
        $postPerformance = $posts->map(function($post) {
            return [
                'title' => $post->title,
                'likes' => $post->likedByUsers->count(),
                'views' => $post->viewedByUsers->count(),
                'comments' => $post->comments->count(),
            ];
        });

        if ($postPerformance->isEmpty()) {
            // Nếu không có bài viết nào trong tháng, không gửi email
            return;
        }

        // Gửi email summary cho user
        Mail::to($this->user->email)->send(new PostSummaryMail($postPerformance, $this->user));
    }
}
