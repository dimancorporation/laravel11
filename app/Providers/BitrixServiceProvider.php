<?php

namespace App\Providers;

use App\Services\Bitrix;
use Bitrix24\SDK\Core\Core;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Illuminate\Support\ServiceProvider;

class BitrixServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Core::class, function ($app) {
            $webhookUrl = config('bitrix24.webhook_url');

            if (empty($webhookUrl)) {
                throw new \InvalidArgumentException('Bitrix24 Webhook URL is not configured.');
            }

            // Create and return the ServiceBuilder instance
            return ServiceBuilderFactory::createServiceBuilderFromWebhook($webhookUrl);
        });
    }

    /**
     *
     */
    public function boot(Bitrix $bitrix): void
    {
        $this->publishes([
            __DIR__.'/../config/bitrix.php' => config_path('bitrix.php'),
        ]);
    }
}
