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

Route::post(
    "$module/check-schedule-plan",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "checkSchedulePlan"]
)->name("$module.check_schedule_plan");

Route::post(
    "$module/get-type-schedule-plan-form",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "getTypeSchedulePlanForm"]
)->name("$module.get_type_schedule_plan_form");

Route::post(
    "$module/save-schedule-plan",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "savePlanSchedule"]
)->name("$module.save_schedule_plan");
Route::post(
    "$module/get-group-input",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "getGroupInput"]
)->name("$module.get_group_input");
Route::post(
    "$module/get-constructor-schedule",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "getConstructorSchedule"]
)->name("$module.get_constructor_schedule");
Route::post(
    "$module/get-from-type-schedule-plan",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "getFormForPair"]
)->name("$module.get_form_for_pair");
Route::post(
    "$module/validate-schedule-fields",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "validateScheduleFields"]
)->name("$module.validate_schedule_fields");
Route::post(
    "$module/set-schedule-plan-cash",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "setSchedulePlanCash"]
)->name("$module.set_schedule_plan_cash");
Route::post(
    "$module/delete-session",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, "deleteSession"]
)->name("$module.delete_session");
Route::post(
    "$module/get-new-card-name",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, 'getNewCardName']
)->name("$module.get_new_card_name");
Route::post(
    "$module/validate-card",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, 'validateCard']
)->name("$module.validate_card");
Route::post(
    "$module/get-subject-input",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, 'getSubjectInput']
)->name("$module.get_subject_input");
Route::post(
    "$module/set-plan-schedule",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, 'setPlanSchedule']
)->name("$module.set_plan_schedule");
Route::get(
    "$module/download-template",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, 'downloadTemplate']
)->name("$module.download_template");
Route::post(
    "$module/download-schedule-file",
    [\App\Modules\Crm\schedule_plan\controllers\SchedulePlanController::class, 'downloadScheduleFile']
)->name("$module.download_schedule_file");
