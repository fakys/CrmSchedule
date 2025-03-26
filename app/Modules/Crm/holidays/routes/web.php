<?php

use App\Modules\Crm\holidays\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

\App\Src\access\AccessRoute::access('action_holiday_settings')->route(
    Route::get("$module/settings", [
        \App\Modules\Crm\holidays\controllers\SettingsController::class , 'actionIndex'
    ])->name("$module.settings")
)->description('страничка для настройки праздничных дней');


Route::post("$module/holiday-form", [
    \App\Modules\Crm\holidays\controllers\SettingsController::class , 'getHolidaysForm'
])->name("$module.holiday_form");


Route::post("$module/set-holiday-form", [
    \App\Modules\Crm\holidays\controllers\SettingsController::class , 'setHolidays'
])->name("$module.set_holiday_form");
