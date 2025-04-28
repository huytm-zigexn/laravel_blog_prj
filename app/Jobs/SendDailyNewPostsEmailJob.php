<?php

namespace App\Jobs;

use App\Mail\DailyNewPostsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDailyNewPostsEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;
    public $posts;
    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($posts, $user)
    {
        $this->posts = $posts;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to user with new posts
        Mail::to($this->user->email)->send(new DailyNewPostsMail($this->posts));
    }
}
