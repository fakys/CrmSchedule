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

Route::get("$module/subjects-info/",
    [
        \App\Modules\Crm\lessons\controllers\SubjectsController::class,
        'actionSubjectsInfo'
    ]
)->name("$module.subjects_info");

