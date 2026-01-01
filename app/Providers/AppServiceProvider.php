<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\PromoNotifikasi;

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
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        // Share notifications with all views
        View::composer('*', function ($view) {
            $unreadNotifications = PromoNotifikasi::orderBy('created_at', 'desc')->take(5)->get();
            $view->with('unreadNotifications', $unreadNotifications);
        });
    }
}
