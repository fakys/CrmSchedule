<?php

use App\Modules\RestApi\schedule_api\controllers\ScheduleApiController;
use App\Modules\RestApi\schedule_api\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

Route::post("/$module/get-all-specialties", [ScheduleApiController::class, 'getAllSpecialties']);
Route::post("/$module/get-all-students-groups", [ScheduleApiController::class, 'getAllStudentsGroups']);
Route::post("/$module/get-all-users", [ScheduleApiController::class, 'getAllUsers']);
Route::post("/$module/get-all-pair-number", [ScheduleApiController::class, 'getPairNumbers']);

