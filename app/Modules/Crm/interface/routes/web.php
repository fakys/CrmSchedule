<?php

use App\Modules\Crm\interface\InfoModule;
use Illuminate\Support\Facades\Route;
$module = InfoModule::getNameModule();

Route::get("$module/", [
    \App\Modules\Crm\interface\controllers\InterfaceController::class , 'actionIndex'
])->name("$module.index");

Route::get("/$module/users", [
    \App\Modules\Crm\interface\controllers\UsersInterfaceController::class , 'actionUsers'
])->name("$module.users");
