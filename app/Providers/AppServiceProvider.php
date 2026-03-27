<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Auto-create SQLite database file if it doesn't exist
        if (config('database.default') === 'sqlite') {
            $database = config('database.connections.sqlite.database');
            if ($database && $database !== ':memory:' && !file_exists($database)) {
                touch($database);
            }
        }
    }
}
