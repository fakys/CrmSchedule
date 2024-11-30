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

Route::post("$module/tabs/get-edit-user-tabs", [
    \App\Modules\Crm\users_interface\controllers\TabsController::class,
    'getEditUserInfoTabs'
])->name("$module.tabs.edit_user_tabs");

Route::post("$module/tabs/set-edit-user-tabs", [
    \App\Modules\Crm\users_interface\controllers\TabsController::class,
    'setEditUserInfoTabs'
])->name("$module.tabs.set_edit_user_tabs");

Route::post("$module/tabs/get-access-tabs", [
    \App\Modules\Crm\users_interface\controllers\TabsController::class,
    'getAccessTabs'
])->name("$module.tabs.get_access_tabs");

    Route::post("$module/tabs/set-access-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'setAccessTabs'
    ])->name("$module.tabs.set_access_tabs");
