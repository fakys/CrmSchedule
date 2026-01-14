<?php

namespace App\Modules\Crm\users_interface\providers;

use App\Modules\Crm\users_interface\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class UsersInterfaceeProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'users_interface';
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
