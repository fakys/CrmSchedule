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
