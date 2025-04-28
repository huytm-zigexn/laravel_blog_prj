<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatisticsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $totalPosts, $crawledPosts, $totalUsers, $totalViews;
    public $topViewedPost, $topLikedPost, $topCommentedPost, $topCategory;

    public function __construct($totalPosts, $crawledPosts, $totalUsers, $totalViews, $topViewedPost, $topLikedPost, $topCommentedPost, $topCategory)
    {
        $this->totalPosts = $totalPosts;
        $this->crawledPosts = $crawledPosts;
        $this->totalUsers = $totalUsers;
        $this->totalViews = $totalViews;
        $this->topViewedPost = $topViewedPost;
        $this->topLikedPost = $topLikedPost;
        $this->topCommentedPost = $topCommentedPost;
        $this->topCategory = $topCategory;
    }

    public function build()
    {
        return $this->subject('Monthly Admin Report')
                    ->view('emails.statistics_summary');
    }
}
