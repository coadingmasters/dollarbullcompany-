<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Auto-create public/storage symlink if missing (e.g. after fresh deploy)
        if (! file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }
    }
}
