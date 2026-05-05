<?php

use App\Modules\Crm\student_groups\controllers\SpecialtiesController;
use App\Modules\Crm\student_groups\controllers\StudentGroupsController;
use App\Modules\Crm\student_groups\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

AccessRoute::access($module."_student_groups_info")->route(
    Route::get("$module/student-groups-info", [StudentGroupsController::class, 'actionStudentGroupsInfo'])
        ->name("$module.student_groups_info")
)->description('Страничка просмотра студенческих групп');

AccessRoute::access($module."_search_student_groups_info")->route(
    Route::post("$module/student-groups-info", [StudentGroupsController::class, 'actionStudentGroupsInfo'])
        ->name("$module.search_student_groups_info")
)->description('Страничка поиска студенческих групп');


AccessRoute::access($module."_add_group")->route(
    Route::any("$module/add-group", [StudentGroupsController::class, 'actionAddGroup'])->name("$module.add_group")
)->description('Страничка добавления студенческих групп');

AccessRoute::access($module."_add_specialty")->route(
    Route::any("$module/add-specialty", [SpecialtiesController::class, 'actionAddSpecialty'])->name("$module.add_specialty")
)->description('Страничка добавления специальностей');


AccessRoute::access($module."_add_specialty")->route(
    Route::get("$module/masse-add-students-group", [StudentGroupsController::class, 'actionMasseAddStudentGroup'])->name("$module.masse_add_students_group")
)->description('Страничка добавления специальностей');
//Route::post("$module/masse-add-students-group", [StudentGroupsController::class, 'masseAddStudentGroup'])->name("$module.masse_add_students_group");

Route::get("$module/download-template-masse-add-students-group", [StudentGroupsController::class, 'actionDownloadTemplateMasseAddTeacher'])
    ->name("$module.download_template_masse_add_students_group");
