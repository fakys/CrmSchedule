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

Route::post(
    "$module/edit-schedule-manager",
    [\App\Modules\Crm\schedule\controllers\AjaxController::class, 'editScheduleManager']
)->name("$module.edit_schedule_manager");


\App\Src\access\AccessRoute::access("$module.semesters")->route(
    Route::get(
        "$module/semesters",
        [\App\Modules\Crm\schedule\controllers\SemestersController::class, "actionSemesters"]
    )->name("$module.semesters")
)->description('Страница с семестрами');

\App\Src\access\AccessRoute::access("$module.add_semesters")->route(
    Route::get(
        "$module/add_semesters",
        [\App\Modules\Crm\schedule\controllers\SemestersController::class, "actionSemestersAdd"]
    )->name("$module.add_semesters")
)->description('Страница добавления семестра');

\App\Src\access\AccessRoute::access("$module.add_semesters")->route(
    Route::post(
        "$module/add_semesters",
        [\App\Modules\Crm\schedule\controllers\SemestersController::class, "semestersAdd"]
    )->name("$module.add_semesters_post")
);
\App\Src\access\AccessRoute::access("$module.delete_semester")->route(
    Route::post(
        "$module/delete_semester",
        [\App\Modules\Crm\schedule\controllers\SemestersController::class, "deleteSemester"]
    )->name("$module.delete_semester")
);
\App\Src\access\AccessRoute::access("$module.semester_edit")->route(
    Route::get(
        "$module/semester-edit",
        [\App\Modules\Crm\schedule\controllers\SemestersController::class, "actionSemestersEdit"]
    )->name("$module.semester_edit")
)->description('Страница изменения семестра');

\App\Src\access\AccessRoute::access("$module.semester_edit")->route(
    Route::post(
        "$module/semester-edit",
        [\App\Modules\Crm\schedule\controllers\SemestersController::class, "semestersEdit"]
    )->name("$module.semester_edit_post")
)->description('Страница изменения семестра');

\App\Src\access\AccessRoute::access("$module.has_schedule_manager_menu")->route(
    Route::post(
        "$module/has-schedule-manager-menu",
        [\App\Modules\Crm\schedule\controllers\AjaxController::class, "hasScheduleManagerMenu"]
    )->name("$module.has_schedule_manager_menu")
)->description('Страница просмотра расписания');
Route::get(
    "$module/has-schedule-cash-task",
    [\App\Modules\Crm\schedule\controllers\AjaxController::class, "checkCashScheduleTask"]
)->name("$module.has_schedule_cash_task");
