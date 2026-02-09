<?php

use App\Modules\Crm\modules_settings\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

AccessRoute::access("{$module}_settings")->route(
    Route::get("$module/settings/",
        [
            \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
            'actionModulesSettings'
        ]
    )->name("$module.settings")
);

AccessRoute::access("{$module}_save_module")->route(
    Route::post("$module/save-module/",
        [
            \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
            'saveModule'
        ]
    )->name("$module.save_modules")
);

AccessRoute::access("{$module}_save_status_modules")->route(
    Route::post("$module/save-status-module/",
        [
            \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
            'saveStatusModules'
        ]
    )->name("$module.save_status_modules")
);
