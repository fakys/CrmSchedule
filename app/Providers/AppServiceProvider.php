<?php

namespace App\Providers;

use App\Src\modules\kernel\KernelModules;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views/layouts/', 'layout');
        $this->loadViewsFrom(__DIR__ . '/../Src/Html/views', 'Html');
//        context()->StartProvider();
        $this->app->singleton(KernelModules::KERNEL_KEY, function ($app) {
            return KernelModules::createKernel($app);
        });
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
