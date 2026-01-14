<?php

namespace App\Modules\Crm\holidays\providers;

use App\Modules\Crm\holidays\InfoModule;
use App\Src\modules\providers\AbstractModulesProvider;
use Illuminate\Support\Facades\Route;

class HolidaysProvider extends AbstractModulesProvider
{
    public function prefixModulePathName(): string
    {
        return 'Crm';
    }

    public function modulePathName(): string
    {
        return 'holidays';
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
