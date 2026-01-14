<?php

namespace App\Modules\Crm\modules_settings\providers;

use App\Modules\Crm\modules_settings\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class ModulesSettingsProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'modules_settings';
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
