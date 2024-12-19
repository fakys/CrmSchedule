<?php
namespace App\Modules\Crm\users_interface\controllers;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;

class UserGroupsController extends Controller{

    public function actionUserGroupsInfo()
    {
        $user_groups = BackendHelper::getRepositories()->getAllUsersGroup();
        return view('user_groups.user_groups_info', ['title'=>'Группы пользователей', 'user_groups' => $user_groups]);
    }
    public function actionUserGroupsAdd()
    {
        $access = BackendHelper::getOperations()->getAccessForForm();
        return view('user_groups.add_user_groups', ['title'=>'Группы пользователей', 'access' => $access]);
    }
}
