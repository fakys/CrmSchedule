<?php

namespace App\Modules\RestApi\schedule_api\providers;

use App\Modules\RestApi\schedule_api\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;
use Illuminate\Support\Facades\Route;

class RestApiProvider extends AbstractModulesProvider
{
    public function prefixModulePathName(): string
    {
        return 'RestApi';
    }

    public function modulePathName(): string
    {
        return 'schedule_api';
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

    }

    public function moduleModel(): string
    {
        return InfoModule::class;
    }
}
