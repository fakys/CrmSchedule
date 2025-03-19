<?php

use App\Modules\Crm\schedule_plan\InfoModule;
use Illuminate\Support\Facades\Route;


$module = InfoModule::getNameModule();


\App\Src\access\AccessRoute::access("$module.schedule_plan")->route(
    Route::get(
        "$module/schedule-plan",
        [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "actionSchedulePlan"]
    )->name("$module.schedule_plan")
)->description('Страница для редактирования/создания плана расписания');


\App\Src\access\AccessRoute::access("$module.schedule_plan_types")->route(
    Route::get(
        "$module/schedule-plan-types",
        [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController::class, "actionSchedulePlanType"]
    )->name("$module.schedule_plan_types")
)->description('Страница для редактирования/создания типов плана расписания');

Route::post(
    "$module/operation-schedule-plan-types",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController::class, "actionTypeSchedulePlanOperation"]
)->name("$module.operation_schedule_plan_types");

Route::post(
    "$module/form-add-type-schedule",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController::class, "formAddTypeSchedulePlan"]
)->name("$module.form_add_type_schedule");
Route::post(
    "$module/add-type-schedule",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController::class, "addSchedulePlanType"]
)->name("$module.add_type_schedule");
