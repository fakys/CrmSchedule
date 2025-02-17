<?php

use App\Modules\Crm\schedule\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();


Route::get(
    "$module/schedule-manager",
    [\App\Modules\Crm\schedule\controllers\ScheduleController::class, "actionScheduleManager"]
)->name("$module.schedule_manager");

Route::post(
    "$module/schedule-manager-menu",
    [\App\Modules\Crm\schedule\controllers\AjaxController::class, "scheduleManagerMenu"]
)->name("$module.schedule_manager_menu");

Route::post(
    "$module/add-schedule-manager-menu",
    [\App\Modules\Crm\schedule\controllers\AjaxController::class, 'addScheduleManagerMenu']
)->name("$module.add_schedule_manager_menu");
