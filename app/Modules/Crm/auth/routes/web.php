<?php

use App\Modules\Crm\auth\InfoModule;
use Illuminate\Support\Facades\Route;


$module = InfoModule::getNameModule();

Route::get("$module/login", [\App\Modules\Crm\auth\controllers\AuthController::class, 'actionLogin'])
    ->name("$module.index")->middleware(\App\Middleware\PublicMiddleware::class);
Route::post("$module/login", [\App\Modules\Crm\auth\controllers\AuthController::class, 'login'])
    ->name("$module.login")->middleware(\App\Middleware\PublicMiddleware::class);

Route::get("$module/logout", [\App\Modules\Crm\auth\controllers\AuthController::class, 'actionLogout'])
    ->name("$module.logout");

