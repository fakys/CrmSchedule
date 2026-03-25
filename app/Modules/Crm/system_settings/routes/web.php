<?php

use App\Modules\Crm\system_settings\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();
AccessRoute::access("{$module}_crm_settings")->route(
    Route::any("/$module/crm-settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionCRMSettings'
        ]
    )->name("$module.crm_settings")
)->description('Настройки crm');

AccessRoute::access("{$module}_settings")->route(
    Route::any("/$module/settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionSystemSettings'
        ]
    )->name("$module.settings")
)->description('Настройки системы');

AccessRoute::access("{$module}_settings")->route(
    Route::any("/$module/schedule-settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionScheduleSettings'
        ]
    )->name("$module.schedule_settings")
)->description('Настройки расписания');
