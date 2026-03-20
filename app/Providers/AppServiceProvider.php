<?php

namespace App\Providers;

use App\Src\abstract\AbstractContext;
use App\Src\Context;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views/layouts/', 'layout');
        $this->loadViewsFrom(__DIR__ . '/../Src/Html/views', 'Html');

        $this->app->bind(AbstractContext::class, function ($app) {
            return new Context(Request::capture());
        });

        $this->app->singleton(KernelModules::KERNEL_KEY, KernelModules::class);
        //Создаем массив с модулями в ядре
        $this->app->singleton(KernelModules::MODULE_KEY, function ($app) {
            return new Collection();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->get(KernelModules::KERNEL_KEY);
    }
}
