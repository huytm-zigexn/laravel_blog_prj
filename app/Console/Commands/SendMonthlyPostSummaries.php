<?php
namespace App\Console\Commands;

use App\Jobs\SendAuthorMonthlyPostSummary;
use App\Models\User;
use Illuminate\Console\Command;

class SendMonthlyPostSummaries extends Command
{
    protected $signature = 'reminders:send-monthly-summary';

    protected $description = 'Send monthly post performance summaries to authors';

    public function handle()
    {
        // Tìm tất cả authors
        $authors = User::where('role', 'author')->whereHas('posts')->get();

        // Gửi email cho từng author
        foreach ($authors as $author) {
            SendAuthorMonthlyPostSummary::dispatch($author);
        }

        $this->info('Monthly summaries sent successfully.');
    }
}
