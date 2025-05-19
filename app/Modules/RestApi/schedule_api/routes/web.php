<?php

use App\Modules\RestApi\schedule_api\controllers\ScheduleApiController;
use App\Modules\RestApi\schedule_api\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

//Route::post("/$module/test", [ScheduleApiController::class, 'getAllSpecialties']);
Route::post("$module/test", function () {
    return response()->json(['status' => 'ok']);
});

