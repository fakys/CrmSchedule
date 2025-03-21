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
Route::post(
    "$module/edit-type-schedule",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController::class, "editSchedulePlanType"]
)->name("$module.edit_type_schedule");
Route::post(
    "$module/delete-week-type-schedule",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController::class, "deleteWeekSchedulePlanType"]
)->name("$module.delete_week_type_schedule");

\App\Src\access\AccessRoute::access("$module.add_schedule_plan")->route(
    Route::get(
        "$module/add-schedule-plan",
        [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "addSchedulePlan"]
    )->name("$module.add_schedule_plan")
)->description('Страница для добавления плана расписания');

Route::post(
    "$module/add-schedule-plan-form",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "addPlanScheduleForm"]
)->name("$module.add_schedule_plan_form");

Route::post(
    "$module/save-schedule-plan",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "savePlanSchedule"]
)->name("$module.save_schedule_plan");
