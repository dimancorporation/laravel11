<?php

namespace App\Providers;

use App\Services\ProgressBarService;
use App\Services\ProgressStatusService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProgressStatusService::class);
        $this->app->singleton(ProgressBarService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
