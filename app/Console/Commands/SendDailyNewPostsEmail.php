<?php
namespace App\Console\Commands;

use App\Jobs\SendDailyNewPostsEmailJob;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;

class SendDailyNewPostsEmail extends Command
{
    protected $signature = 'send:daily-new-posts';
    protected $description = 'Send daily email to users with new posts';

    public function handle()
    {
        $today = Carbon::today();

        $posts = Post::whereDate('created_at', $today)->get();

        if ($posts->isEmpty()) {
            $this->info('There are no new posts today.');
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            SendDailyNewPostsEmailJob::dispatch($posts, $user);
        }

        $this->info('Sent daily new posts email to all users.');
    }
}
