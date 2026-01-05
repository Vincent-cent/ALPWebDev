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
        // Load helpers
        require_once app_path('Helpers/ImageHelper.php');
        
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        // Share unread notifications with all views
        View::composer(['layouts.mainLayout', 'layouts.components._notification-dropdown'], function ($view) {
            $unreadNotifications = PromoNotifikasi::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
            
            $view->with('unreadNotifications', $unreadNotifications);
        });
    }
}

