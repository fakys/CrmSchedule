<?php

namespace App\Modules\Crm\interface\providers;

use App\Modules\Crm\interface\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class InterfaceProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'interface';
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
