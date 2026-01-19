<?php

namespace App\Providers;

use App\Src\modules\kernel\KernelConstructor;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ViewsProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views/layouts/', 'layout');
        $this->loadViewsFrom(__DIR__ . '/../Src/Html/views', 'Html');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->get(KernelConstructor::KERNEL_CONSTRUCT);
    }
}
