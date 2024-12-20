<?php
namespace App\Modules\Crm\users_interface\controllers;
use App\Modules\Crm\users_interface\model\UserAddGroups;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Таб для добавления групп
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createUserGroups()
    {
        $model = new UserAddGroups();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            BackendHelper::getRepositories()->createUsersGroup($model->name, $model->getAccesses(), $model->active, $model->description);
        }
        return redirect()->route('users_interface.user_groups_info');
    }

    /**
     * Таб для добавления пользователя в группы
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setUsersGroupTabs()
    {
        $model = new UserAddGroups();
        $model->load(request()->post());
        return BackendHelper::getOperations()->addUserInGroups($model->user_id, $model->groups);
    }
}
