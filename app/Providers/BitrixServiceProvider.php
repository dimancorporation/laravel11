<?php

namespace App\Providers;

use Bitrix24\SDK\Core\Core;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class BitrixServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ServiceBuilder::class, function ($app) {
            $webhookUrl = config('bitrix.webhook_url');

            if (empty($webhookUrl)) {
                throw new InvalidArgumentException('Bitrix24 Webhook URL is not configured.');
            }

            return ServiceBuilderFactory::createServiceBuilderFromWebhook($webhookUrl);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../Config/bitrix.php' => config_path('bitrix.php'),
        ]);
    }
}
