<?php

use App\Modules\Crm\reports\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

AccessRoute::access("{$module}_for_group")->route(
    Route::any("$module/report-for-group", [
        \App\Modules\Crm\reports\controllers\ReportsController::class,
        'actionReportForGroup'
    ])->name("$module.report_for_group")
);
