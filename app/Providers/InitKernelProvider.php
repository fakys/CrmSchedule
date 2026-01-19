<?php

namespace App\Providers;

use App\Entity\User;
use App\Src\modules\kernel\KernelConstructor;
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
        /** @var KernelConstructor $kernel */
        $kernel = $this->app->get(KernelConstructor::KERNEL_CONSTRUCT);
        $kernel->InitKernel();
    }
}
