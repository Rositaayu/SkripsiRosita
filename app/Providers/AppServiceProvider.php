<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('admin', function (User $user) {
            return $user->role == 'admin';
        });

        Gate::define('super_editor', function (User $user) {
            return $user->role == 'super_editor';
        });

        Gate::define('editor', function (User $user) {
            return $user->role == 'editor';
        });

        Gate::define('wartawan', function (User $user) {
            return $user->role == 'wartawan';
        });
    }
}
