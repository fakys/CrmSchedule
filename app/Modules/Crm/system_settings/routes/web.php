<?php

use App\Modules\Crm\system_settings\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();
AccessRoute::access("{$module}_settings")->route(
    Route::get("/$module/settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'actionSystemSettings'
        ]
    )->name("$module.settings")
);

AccessRoute::access("{$module}_set_settings")->route(
    Route::post("/$module/settings",
        [
            \App\Modules\Crm\system_settings\controllers\SettingsController::class,
            'setSystemSettings'
        ]
    )->name("$module.set-settings")
);

