<?php

namespace App\Providers;

use App\Services\IncomingWebhookDealService;
use App\Services\IncomingWebhookInvoiceService;
use App\Services\ProgressBarService;
use App\Services\ProgressStatusService;
use App\Services\UpdateCRMService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IncomingWebhookDealService::class);
        $this->app->singleton(IncomingWebhookInvoiceService::class);
        $this->app->singleton(ProgressStatusService::class);
        $this->app->singleton(ProgressBarService::class);
        $this->app->singleton(ServiceBuilder::class);
        $this->app->bind(UpdateCRMService::class, function ($app) {
            return new UpdateCRMService($app[ServiceBuilder::class]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
