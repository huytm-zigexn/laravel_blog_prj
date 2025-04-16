<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $data = collect(); // default empty in case user is not logged in
    
            if (Auth::check()) {
                $data = Notification::where('notifiable_id', Auth::id())
                    ->pluck('data')
                    ->map(function ($d) {
                        return json_decode($d, true);
                    });
            }
    
            $view->with('data', $data);
        });
    }
}
