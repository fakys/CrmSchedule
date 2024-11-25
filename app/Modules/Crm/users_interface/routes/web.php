<?php

use App\Modules\Crm\users_interface\InfoModule;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();


Route::get("$module/users-info", [
    \App\Modules\Crm\users_interface\controllers\UsersController::class,
    'actionUsersInfo'
])->name("$module.users_info");

Route::post("$module/tabs/users-tabs", [
    \App\Modules\Crm\users_interface\controllers\TabsController::class,
    'getUsersTableTabs'
])->name("$module.tabs.users_tabs");

Route::post("$module/tabs/get-user-tabs", [
    \App\Modules\Crm\users_interface\controllers\TabsController::class,
    'getUserInfoTabs'
])->name("$module.tabs.user_tabs");
