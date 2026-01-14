<?php

namespace App\Modules\Crm\schedule_plan\providers;

use App\Modules\Crm\schedule_plan\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class SchedulePlanProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'schedule_plan';
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
