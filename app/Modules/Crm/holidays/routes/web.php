<?php

use App\Modules\Crm\holidays\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

//\App\Src\access\AccessRoute::access('action_holiday_settings')->route(
//
//)->description('страничка для настройки праздничных дней');
Route::get("$module/settings", [
    \App\Modules\Crm\holidays\controllers\SettingsController::class , 'actionIndex'
])->name("$module.settings");

Route::post("$module/holiday-form", [
    \App\Modules\Crm\holidays\controllers\SettingsController::class , 'getHolidaysForm'
])->name("$module.holiday_form");


Route::post("$module/set-holiday-form", [
    \App\Modules\Crm\holidays\controllers\SettingsController::class , 'setHolidays'
])->name("$module.set_holiday_form");


\App\Src\access\AccessRoute::access('action_holidays')->route(
    Route::get("$module/holidays", [
        \App\Modules\Crm\holidays\controllers\HolidaysController::class , 'actionIndex'
    ])->name("$module.holidays")
)->description('страничка для настройки праздничных дней по датам');

\App\Src\access\AccessRoute::access('action_holidays')->route(
    Route::get("$module/add-action-holiday", [
        \App\Modules\Crm\holidays\controllers\HolidaysController::class , 'actionAddHoliday'
    ])->name("$module.add_action_holiday")
)->description('страничка для добавления праздников');

Route::post("$module/add-holiday", [
    \App\Modules\Crm\holidays\controllers\HolidaysController::class , 'addHoliday'
])->name("$module.add_holiday");

\App\Src\access\AccessRoute::access('edit_action_holidays')->route(
    Route::get("$module/edit-action-holidays", [
        \App\Modules\Crm\holidays\controllers\HolidaysController::class , 'actionEditHoliday'
    ])->name("$module.edit_action_holidays")
)->description('страничка для редактирования праздников');

Route::post("$module/edit-holidays", [
    \App\Modules\Crm\holidays\controllers\HolidaysController::class , 'editHoliday'
])->name("$module.edit_holidays");

\App\Src\access\AccessRoute::access('delete_holidays')->route(
    Route::post("$module/delete-holidays", [
        \App\Modules\Crm\holidays\controllers\HolidaysController::class , 'actionDeleteHoliday'
    ])->name("$module.delete_holidays")
)->description('страничка для удаления праздников');
