<?php

namespace App\Providers;

use App\Src\modules\kernel\KernelConstructor;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CreateContextForKernelProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(KernelConstructor::KERNEL_CONSTRUCT, function ($app) {
            return KernelConstructor::createKernel($app);
        });
        //Создаем массив с модулями в ядре
        $this->app->singleton(KernelConstructor::MODULE_KEY, function ($app) {
            return new Collection();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
