<?php

namespace App\Providers;

use App\Services\DashboardService;
use App\Services\IncomingWebhookDealService;
use App\Services\IncomingWebhookInvoiceService;
use App\Services\PaymentService;
use App\Services\InvoiceService;
use App\Services\ProgressBarService;
use App\Services\ProgressStatusService;
use App\Services\SettingsService;
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
        $this->app->singleton(PaymentService::class);
        $this->app->singleton(InvoiceService::class);
        $this->app->singleton(ProgressStatusService::class);
        $this->app->singleton(ProgressBarService::class);
        $this->app->singleton(DashboardService::class);
        $this->app->singleton(SettingsService::class);
        $this->app->singleton(ServiceBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
