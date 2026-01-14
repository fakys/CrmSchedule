<?php

namespace App\Modules\Crm\lessons\providers;

use App\Modules\Crm\lessons\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;

class LessonsProvider extends AbstractModulesProvider
{

    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'lessons';
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
