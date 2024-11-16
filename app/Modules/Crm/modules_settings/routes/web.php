<?php

use App\Modules\Crm\modules_settings\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();
Route::get("$module/settings/",
    [
        \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
        'actionModulesSettings'
    ]
)->name("$module.settings");
Route::get("$module/add-module/",
    [
        \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
        'actionAddModule'
    ]
)->name("$module.add_module");
Route::post("$module/save-module/",
    [
        \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
        'saveModule'
    ]
)->name("$module.save_modules");

Route::post("$module/save-status-module/",
    [
        \App\Modules\Crm\modules_settings\controllers\ModulesSettingsController::class,
        'saveStatusModules'
    ]
)->name("$module.save_status_modules");
