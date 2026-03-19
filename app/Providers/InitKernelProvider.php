<?php

namespace App\Providers;

use App\Entity\User;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class InitKernelProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::getRoutes()->refreshNameLookups();
        /** @var KernelModules $kernel */
        $kernel = $this->app->get(KernelModules::KERNEL_KEY);
        $kernel->InitKernel();
    }
}
