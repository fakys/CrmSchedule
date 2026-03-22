<?php

namespace App\Services\ProviderLoader\Providers;


use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\ProviderLoader\Domain\Services\ProviderLoaderInterface;
use App\Services\ProviderLoader\Infrastructure\Services\Events\BootProviderLoaderEvent;
use App\Services\ProviderLoader\Infrastructure\Services\ProviderLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/** Загрузчик сервисов */
class ProviderLoaderProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ProviderLoaderInterface::class, function () {
            /** @var \App\Services\ProviderLoader\Domain\Services\ProviderInterface[] $providers */
            $providers = require base_path('bootstrap/services_providers.php');

            $loader = new ProviderLoader($providers);
            foreach ($providers as $service_provider) {
                $loader->loadService($service_provider::serviceName());
            }
            return $loader;
        });
        //Регистрируем провайдеры
        $this->app->get(ProviderLoaderInterface::class);
    }
    public function boot()
    {
        Event::dispatch(new BootProviderLoaderEvent(app()));
    }
}
