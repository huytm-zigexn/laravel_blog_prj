<?php

namespace App\Providers;

use App\Models\Like;
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
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->map(function ($notification) {
                            $decoded = json_decode($notification->data, true);
                            $decoded['created_at'] = $notification->created_at;
                            $decoded['id'] = $notification->id;
                            return $decoded;
                        });
            }
    
            $view->with('data', $data);

            $roleColors = [
                'admin' => 'danger',
                'author' => 'success',
                'reader' => 'secondary',
            ];

            $view->with('roleColors', $roleColors);
        });
    }
}
