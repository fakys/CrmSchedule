<?php

namespace App\Modules\Crm\student_groups\providers;

use App\Modules\Crm\student_groups\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class StudentGroupsProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'student_groups';
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
