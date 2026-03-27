<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('database.default') === 'sqlite' && !app()->runningUnitTests()) {
            $database = config('database.connections.sqlite.database');
            if ($database && $database !== ':memory:') {
                try {
                    // Ensure storage directory exists
                    $dir = dirname($database);
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }

                    if (!file_exists($database)) {
                        touch($database);
                    }

                    if (!Schema::hasTable('users')) {
                        Artisan::call('migrate', ['--force' => true]);
                        Artisan::call('db:seed', ['--force' => true]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Database auto-init failed: ' . $e->getMessage());
                }
            }
        }
    }
}
