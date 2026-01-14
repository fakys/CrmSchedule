<?php

namespace App\Modules\Crm\backend_module\providers;

use App\Modules\Crm\backend_module\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class BackendModuleProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'backend_module';
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
