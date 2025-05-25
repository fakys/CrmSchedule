<?php

use App\Modules\RestApi\schedule_api\controllers\ScheduleApiController;
use App\Modules\RestApi\schedule_api\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

Route::post("/$module/get-all-specialties", [ScheduleApiController::class, 'getAllSpecialties']);
Route::post("/$module/get-all-students-groups", [ScheduleApiController::class, 'getAllStudentsGroups']);
Route::post("/$module/get-all-users", [ScheduleApiController::class, 'getAllUsers']);
Route::post("/$module/get-all-pair-number", [ScheduleApiController::class, 'getPairNumbers']);
Route::post("/$module/get-actual-schedule-by-group", [ScheduleApiController::class, 'getActualScheduleByGroup']);
Route::post("/$module/get-group-by-name", [ScheduleApiController::class, 'getGroupByName']);
Route::post("/$module/has-students-groups", [ScheduleApiController::class, 'hasStudentsGroups']);
Route::post("/$module/has-teacher", [ScheduleApiController::class, 'hasTeacher']);
Route::post("/$module/get-actual-schedule-by-teacher", [ScheduleApiController::class, 'getActualScheduleByTeacher']);

