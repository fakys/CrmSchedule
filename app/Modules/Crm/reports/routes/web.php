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


AccessRoute::access("{$module}_export_excel")->route(
    Route::post("$module/export-excel", [
        \App\Modules\Crm\reports\controllers\ReportsController::class,
        'exportReport'
    ])->name("$module.export_excel")
);

Route::post("$module/check-export-excel", [
    \App\Modules\Crm\reports\controllers\ReportsController::class,
    'checkExport'
])->name("$module.check_export_excel");

Route::get("$module/download-export-excel", [
    \App\Modules\Crm\reports\controllers\ReportsController::class,
    'downloadFile'
])->name("$module.download_export_excel");

