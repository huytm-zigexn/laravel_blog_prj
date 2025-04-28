<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('send:daily-new-posts')
    ->daily()
    ->at('08:00');

Schedule::command('reminders:send-posts')
    ->daily();

Schedule::command('reminders:send-monthly-summary')
    ->monthly();

Schedule::command('report:send-admin-monthly')
    ->monthly();
