<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendMonthlyAdminReport;

class SendAdminMonthlyReport extends Command
{
    protected $signature = 'report:send-admin-monthly';
    protected $description = 'Send monthly statistics report to admin';

    public function handle()
    {
        SendMonthlyAdminReport::dispatch();
        $this->info('Admin monthly report dispatched.');
    }
}
