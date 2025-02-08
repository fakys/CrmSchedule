<?php

use App\Modules\Crm\users_interface\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

$module = InfoModule::getNameModule();

AccessRoute::access("{$module}_users_info")->route(
    Route::any("$module/users-info", [
        \App\Modules\Crm\users_interface\controllers\UsersController::class,
        'actionUsersInfo'
    ])->name("$module.users_info")
);

AccessRoute::access("{$module}_add_user")->route(
    Route::get("$module/add-user", [
        \App\Modules\Crm\users_interface\controllers\UsersController::class,
        'actionAddUser'
    ])->name("$module.add_user")
)->description('Страница добавления пользователя');

AccessRoute::access("{$module}_add_user_post")->route(
    Route::post("$module/add-user-post", [
        \App\Modules\Crm\users_interface\controllers\UsersController::class,
        'addUser'
    ])->name("$module.add_user_post")
)->description('Ссылка для сохранения добавленного пользователя');


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

AccessRoute::access("{$module}_create_user_groups")->route(
    Route::post("$module/create-user-groups", [
        \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
        'createUserGroups'
    ])->name("$module.create_user_groups")
);

AccessRoute::access("{$module}_tabs_set_users_group_tabs")->route(
    Route::post("$module/tabs/set-users-group-tabs", [
        \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
        'setUsersGroupTabs'
    ])->name("$module.add_user_groups")
);

AccessRoute::access("{$module}_edit_users_group_action")->route(
    Route::get("$module/edit-users-group", [
        \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
        'actionEditUserGroups'
    ])->name("$module.edit_users_group_action")
);

AccessRoute::access("{$module}_edit_users_group")->route(
    Route::post("$module/edit-users-group", [
        \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
        'editUserGroups'
    ])->name("$module.edit_users_group")
);

Route::post("$module/edit-users-group", [
    \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
    'editUserGroups'
])->name("$module.edit_users_group");


Route::post("$module/user/check-accesses", [
    \App\Modules\Crm\users_interface\controllers\UsersController::class,
    'checkUserAccess'
])->name("$module.check_accesses");

AccessRoute::access("{$module}_delete_user_groups")->route(
    Route::post("/$module/delete-user-groups",
        [
            \App\Modules\Crm\users_interface\controllers\UserGroupsController::class,
            'deleteUserGroups'
        ]
    )->name("$module.delete_user_groups")
);

AccessRoute::access("{$module}_action_accesses")->route(
    Route::get("/$module/accesses",
        [
            \App\Modules\Crm\users_interface\controllers\AccessesController::class,
            'actionAccesses'
        ]
    )->name("$module.accesses")
)->description("страница всех доступов");

AccessRoute::access("{$module}_get_tab_for_student_groups")->route(
    Route::post("/$module/get-tab-for-student-groups",
        [
            \App\Modules\Crm\users_interface\controllers\TabsController::class,
            'getTabForStudentGroups'
        ]
    )->name("$module.get_tab_for_student_groups")
)->description("Доступ к табу групп студентов");

AccessRoute::access("{$module}_get_tab_full_info_student_groups")->route(
    Route::post("/$module/get-tab-full-info-student-groups",
        [
            \App\Modules\Crm\users_interface\controllers\TabsController::class,
            'getFullInfoStudentGroups'
        ]
    )->name("$module.tabs.get_tab_full_info_student_groups")
)->description("Таб информация о группе и специальности");

AccessRoute::access("{$module}_edit_tab_full_info_student_groups")->route(
    Route::post("/$module/edit-tab-full-info-student-groups",
        [
            \App\Modules\Crm\users_interface\controllers\TabsController::class,
            'editFullInfoStudentGroups'
        ]
    )->name("$module.tabs.edit_tab_full_info_student_groups")
)->description("Таб редактирования информация о группе и специальности");

Route::post("/$module/set-edit-tab-student-groups",
    [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'setEditStudentGroups'
    ]
)->name("$module.tabs.set_edit_student_groups");

Route::post("/$module/get-tab-for-subjects",
    [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getTabForSubjects'
    ]
)->name("$module.get_tab_for_subjects");

Route::post("/$module/get-subject-info-tab",
    [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'getSubjectInfoTab'
    ]
)->name("$module.tabs.get_subject_info_tab");

Route::post("/$module/action-edit-subject-info-tab",
    [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'actionEditSubjectInfoTab'
    ]
)->name("$module.tabs.action_edit_subject_info_tab");

Route::post("/$module/edit-subject-info-tab",
    [
        \App\Modules\Crm\users_interface\controllers\TabsController::class,
        'editSubjectInfoTab'
    ]
)->name("$module.tabs.edit_subject_info_tab");

