<?php

namespace App\Console\Commands;

use App\Jobs\SendPostReminder;
use App\Models\User;
use Illuminate\Console\Command;

class SendPostReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to authors who have not posted in a while';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('role', 'author')
            ->whereDoesntHave('posts', function ($query) {
                $query->where('published_at', '>=', now()->subDay(30));
            })->get();

        // Send reminder email to each user
        foreach ($users as $user) {
            SendPostReminder::dispatch($user);
        }

        $this->info('Post reminders sent successfully.');
    }
}
