<?php

use App\Modules\Crm\lessons\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

AccessRoute::access("{$module}_action_add_subject")->route(
    Route::get("$module/add-subject/",
        [
            \App\Modules\Crm\lessons\controllers\SubjectsController::class,
            'actionAddSubject'
        ]
    )->name("$module.action_add_subject")
)->description('Страница создания предметов');

Route::post("$module/add-subject/",
    [
        \App\Modules\Crm\lessons\controllers\SubjectsController::class,
        'addSubject'
    ]
)->name("$module.add_subject");

Route::any("$module/subjects-info/",
    [
        \App\Modules\Crm\lessons\controllers\SubjectsController::class,
        'actionSubjectsInfo'
    ]
)->name("$module.subjects_info");

AccessRoute::access("{$module}_action_add_subject")->route(
    Route::get("$module/pair-number/",
        [
            \App\Modules\Crm\lessons\controllers\LessonsController::class,
            'actionNumberPair'
        ]
    )->name("$module.pair_number")
)->description('Последовательность пар');

AccessRoute::access("{$module}_action_pair_number")->route(
    Route::get("$module/action-add-pair-number/",
        [
            \App\Modules\Crm\lessons\controllers\LessonsController::class,
            'actionAddNumberPair'
        ]
    )->name("$module.action_add_pair_number")
)->description('Добавить последовательность пар');

Route::post("$module/add-pair-number/",
    [
        \App\Modules\Crm\lessons\controllers\LessonsController::class,
        'addNumberPair'
    ]
)->name("$module.add_pair_number");
AccessRoute::access("{$module}_action_update_pair_number")->route(
    Route::get("$module/action-update-pair-number/",
        [
            \App\Modules\Crm\lessons\controllers\LessonsController::class,
            'actionUpdateNumberPair'
        ]
    )->name("$module.action_update_pair_number")
)->description('Изменения последовательность пар');

Route::post("$module/update-pair-number/",
    [
        \App\Modules\Crm\lessons\controllers\LessonsController::class,
        'updateNumberPair'
    ]
)->name("$module.update_pair_number");

AccessRoute::access("{$module}_delete_pair_number")->route(
    Route::post("$module/delete-pair-number/",
        [
            \App\Modules\Crm\lessons\controllers\LessonsController::class,
            'deleteNumberPaid'
        ]
    )->name("$module.delete_pair_number")
)->description('Удаление последовательность пар');

AccessRoute::access("{$module}_lessons")->route(
    Route::get("$module/lessons/",
        [
            \App\Modules\Crm\lessons\controllers\LessonsController::class,
            'actionLessons'
        ]
    )->name("$module.lessons")
)->description('Страница связи преподавателя и предмета');

Route::post("$module/get-tabs/",
    [
        \App\Modules\Crm\lessons\controllers\TabsController::class,
        'getTabsByLesson'
    ]
)->name("$module.get_tabs");

Route::post("$module/get-lessons-info-tab/",
    [
        \App\Modules\Crm\lessons\controllers\TabsController::class,
        'getLessonsInfoTab'
    ]
)->name("$module.get_lessons_info_tab");

Route::post("$module/get-edit-lessons-info-tab/",
    [
        \App\Modules\Crm\lessons\controllers\TabsController::class,
        'getEditLessonsInfoTab'
    ]
)->name("$module.get_edit_lessons_info_tab");

Route::get("$module/add-lesson/",
    [
        \App\Modules\Crm\lessons\controllers\LessonsController::class,
        'actionAddLesson'
    ]
)->name("$module.add_lesson");

Route::post("$module/set-lesson/",
    [
        \App\Modules\Crm\lessons\controllers\LessonsController::class,
        'setLesson'
    ]
)->name("$module.set_lesson");

Route::post("$module/edit-lessons-info/",
    [
        \App\Modules\Crm\lessons\controllers\TabsController::class,
        'editLessonsInfo'
    ]
)->name("$module.edit_lessons_info");
