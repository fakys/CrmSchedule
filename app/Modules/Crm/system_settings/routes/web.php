<?php

use App\Modules\Crm\system_settings\InfoModule;
use Illuminate\Support\Facades\Route;

(new InfoModule())->runConfig();
$module = InfoModule::getNameModule();

Route::get("/$module/settings",
    [
        \App\Modules\Crm\system_settings\controllers\SettingsController::class,
        'actionSystemSettings'
    ]
)->name("$module.settings");

Route::post("/$module/settings",
    [
        \App\Modules\Crm\system_settings\controllers\SettingsController::class,
        'setSystemSettings'
    ]
)->name("$module.set-settings");
