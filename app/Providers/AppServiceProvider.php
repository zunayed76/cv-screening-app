<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        //
        // Define gates for candidate and company roles
        Gate::define('is-candidate', function ($user) {
            return $user->role === 'candidate';
        });

        Gate::define('is-company', function ($user) {
            return in_array($user->role, ['company', 'admin']);
        });
    }
}
