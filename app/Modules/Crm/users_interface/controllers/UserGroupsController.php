<?php
namespace App\Modules\Crm\users_interface\controllers;
use App\Modules\Crm\users_interface\model\UserAddGroups;
use App\Modules\Crm\users_interface\model\UsersGroup;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class UserGroupsController extends AbstractController {

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('users_list')
            ->RmLink('users_group')->setText('Группы')
            ->setLink(route('users_interface.user_groups_info'));
    }
    public function actionUserGroupsInfo()
    {
        $user_groups = BackendHelper::getRepositories()->getAllUsersGroup();
        return view('user_groups.user_groups_info', [
            'title'=>'Группы пользователей', 'user_groups' => $user_groups, 'nav_users'=>true
        ]);
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
        $model = new UsersGroup();
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

    /**
     * Страничка редактирования групп пользователей
     * @param $user_group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|void
     */
    public function actionEditUserGroups()
    {
        if(request()->get('group_id')){
            $group_id = request()->get('group_id');
            $group = BackendHelper::getRepositories()->getUsersGroupById($group_id);
            if($group){
                $access = BackendHelper::getOperations()->getAccessForForm();
                $access_data = ArrayHelper::valueIsKey($group->getAccesses());
                return view('user_groups.add_user_groups', [
                    'title'=>'Группы пользователей',
                    'access' => $access,
                    'access_data' => $access_data,
                    'group' => $group
                ]);
            }
        }
        abort(404);
    }


    /**
     * Таб для обновления групп пользователей
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editUserGroups()
    {
        if(request()->post('group_id')){
            $model = new UsersGroup();
            $model->load(request()->post());
            $validate = Validator::make($model->getData(), $model->rules());
            if($validate->validate()){
                BackendHelper::getRepositories()->updateUserGroup(
                    request()->post('group_id'),
                    $model->name, $model->getAccesses(),
                    $model->active, $model->description
                );
            }
            return redirect()->route('users_interface.user_groups_info');
        }
        abort(404);
    }

    /**
     * Удаляет группу пользователей по id
     */
    public function deleteUserGroups()
    {
        $group_id = request()->post('group_id');
        if($group_id){
            return BackendHelper::getRepositories()->deleteUserGroupById($group_id);
        }
        abort(409);
    }
}


