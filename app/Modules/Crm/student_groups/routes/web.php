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
    Route::post("$module/search-student-groups-info", [StudentGroupsController::class, 'actionStudentGroupsInfo'])
        ->name("$module.search_student_groups_info")
)->description('Страничка поиска студенческих групп');


AccessRoute::access($module."_add_group")->route(
    Route::get("$module/add-group", [StudentGroupsController::class, 'actionAddGroup'])->name("$module.add_group")
)->description('Страничка добавления студенческих групп');

AccessRoute::access($module."_add_specialty")->route(
    Route::get("$module/add-specialty", [SpecialtiesController::class, 'actionAddSpecialty'])->name("$module.add_specialty")
)->description('Страничка добавления специальностей');

Route::post("$module/add-specialty-post", [SpecialtiesController::class, 'addSpecialty'])->name("$module.add_specialty_post");

Route::post("$module/add-student-group-post", [StudentGroupsController::class, 'addGroup'])->name("$module.add_student_group_post");
