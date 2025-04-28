<?php
namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Mail\AdminMonthlyReportMail;
use App\Mail\StatisticsMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendMonthlyAdminReport implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function handle()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Tổng số bài viết
        $totalPosts = Post::whereBetween('published_at', [$startOfMonth, $endOfMonth])->count();

        // Tổng số bài viết đã crawled
        $crawledPosts = Post::where('is_crawled', true)->whereBetween('published_at', [$startOfMonth, $endOfMonth])->count();

        // Tổng số người dùng
        $totalUsers = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Tổng số views cho tất cả bài viết
        $totalViews = DB::table('post_views')
            ->whereBetween('viewed_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Bài viết nhiều view nhất
        $topViewedPost = Post::withCount('viewedByUsers')
            ->orderByDesc('viewed_by_users_count')
            ->first();

        // Bài viết nhiều like nhất
        $topLikedPost = Post::withCount('likedByUsers')
            ->orderByDesc('liked_by_users_count')
            ->first();

        // Bài viết nhiều comment nhất
        $topCommentedPost = Post::withCount('comments')
            ->orderByDesc('comments_count')
            ->first();

        // Danh mục phổ biến nhất theo tổng số views
        $topCategory = Category::with(['posts' => function ($query) {
                $query->withCount('viewedByUsers')
                    ->orderByDesc('viewed_by_users_count');
            }])
            ->get()
            ->map(function ($category) {
                $category->total_views = $category->posts->sum('viewed_by_users_count');
                return $category;
            })
            ->sortByDesc('total_views')
            ->first();

        // Gửi email cho admin
        Mail::to(config('mail.admin_email'))
            ->send(new StatisticsMail(
                $totalPosts,
                $crawledPosts,
                $totalUsers,
                $totalViews,
                $topViewedPost,
                $topLikedPost,
                $topCommentedPost,
                $topCategory
            ));
    }
}
