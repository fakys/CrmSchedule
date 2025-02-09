<?php

use App\Modules\Crm\system_settings\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();
AccessRoute::access("{$module}_crm_settings")->route(
    Route::get("/$module/crm-settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionCRMSettings'
        ]
    )->name("$module.crm_settings")
)->description('Настройки crm');

Route::post("/$module/settings",
    [
        \App\Modules\Crm\system_settings\controllers\SettingsController::class,
        'setCrmSettings'
    ]
)->name("$module.set-settings");

AccessRoute::access("{$module}_settings")->route(
    Route::get("/$module/settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionSystemSettings'
        ]
    )->name("$module.settings")
)->description('Настройки системы');

Route::post("/$module/set-system-settings",
    [
        \App\Modules\Crm\system_settings\controllers\SettingsController::class,
        'setSystemSettings'
    ]
)->name("$module.set_system_settings");

AccessRoute::access("{$module}_settings")->route(
    Route::get("/$module/schedule-settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionScheduleSettings'
        ]
    )->name("$module.schedule_settings")
)->description('Настройки расписания');

Route::post("/$module/set-schedule-settings",
    [
        \App\Modules\Crm\system_settings\controllers\SettingsController::class,
        'setScheduleSettings'
    ]
)->name("$module.set_schedule_settings");
