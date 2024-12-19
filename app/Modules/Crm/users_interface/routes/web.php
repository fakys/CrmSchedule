<?php

use App\Modules\Crm\users_interface\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

AccessRoute::access("{$module}_users_info")->route(
    Route::get("$module/users-info", [
        \App\Modules\Crm\users_interface\controllers\UsersController::class,
        'actionUsersInfo'
    ])->name("$module.users_info")
);
AccessRoute::access("{$module}_tabs_users_tabs")->route(
    Route::post("$module/tabs/users-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getUsersTableTabs'
    ])->name("$module.tabs.users_tabs")
);

AccessRoute::access("{$module}_tabs_user_tabs")->route(
    Route::post("$module/tabs/get-user-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getUserInfoTabs'
    ])->name("$module.tabs.user_tabs")
);


AccessRoute::access("{$module}_tabs_edit_user_tabs")->route(
    Route::post("$module/tabs/get-edit-user-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getEditUserInfoTabs'
    ])->name("$module.tabs.edit_user_tabs")
);

AccessRoute::access("{$module}_tabs_set_edit_user_tabs")->route(
    Route::post("$module/tabs/set-edit-user-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'setEditUserInfoTabs'
    ])->name("$module.tabs.set_edit_user_tabs")
);

AccessRoute::access("{$module}_tabs_get_access_tabs")->route(
    Route::post("$module/tabs/get-access-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getAccessTabs'
    ])->name("$module.tabs.get_access_tabs")
);

AccessRoute::access("{$module}_tabs_set_access_tabs")->route(
    Route::post("$module/tabs/set-access-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'setAccessTabs'
    ])->name("$module.tabs.set_access_tabs")
);

AccessRoute::access("{$module}_tabs_get_role_tabs")->route(
    Route::post("$module/tabs/get-role-tabs", [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getUserGroupsTabs'
    ])->name("$module.tabs.get_role_tabs")
);

AccessRoute::access("{$module}_user_groups_info")->route(
    Route::get("$module/user-groups-info", [
        \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
        'actionUserGroupsInfo'
    ])->name("$module.user_groups_info")
);

AccessRoute::access("{$module}_user_groups_add")->route(
    Route::get("$module/user-groups-add", [
        \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
        'actionUserGroupsAdd'
    ])->name("$module.user_groups_add")
);

