<?php
namespace App\Modules\Crm\users_interface\controllers;
use App\Assets\LayoutBundle;
use App\Modules\Crm\users_interface\assets\UserGroupBundle;
use App\Modules\Crm\users_interface\model\UserAddGroups;
use App\Modules\Crm\users_interface\model\UsersGroupFrom;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\AssetsBundle\Domain\Facades\AssetBundleManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
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

    static function assets(): array
    {
        return [];
    }

    public function actionUserGroupsInfo()
    {
        $user_groups = BackendHelper::getRepositories()->getAllUsersGroup();
        AssetBundleManager::appendBundle(new UserGroupBundle());

        return view('users_interface::user_groups.user_groups_info', [
            'title'=>'Группы пользователей', 'user_groups' => $user_groups, 'nav_users'=>true
        ]);
    }
    public function actionUserGroupsAdd()
    {
        AssetBundleManager::appendBundle(new LayoutBundle());
        $form = new UsersGroupFrom('form', new FormAdditionalParam('post', route('users_interface.user_groups_add')));

        if (request()->post()) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();

            BackendHelper::getRepositories()->createUsersGroup($return_data->getName(), json_encode($return_data->getAccesses()), $return_data->getDescription());
            return redirect()
                ->route('users_interface.user_groups_info')
                ->with(['successMessage' => 'Группа пользователя успешно создана']);
        }

        ViewManager::appendElement($form);
        return view('users_interface::user_groups.add_user_groups', ['title'=>'Группы пользователей']);
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
     */
    public function actionEditUserGroups()
    {
        if(request()->get('group_id')){
            $group_id = request()->get('group_id');
            $group = BackendHelper::getRepositories()->getUsersGroupById($group_id);
            if($group){
                AssetBundleManager::appendBundle(new LayoutBundle());
                $form = new UsersGroupFrom(
                    'form',
                    new FormAdditionalParam(
                        'post',
                        route('users_interface.edit_users_group_action', ['group_id' => $group_id])
                    ),
                    $group_id
                );
                $group_data = $group->toArray();
                $group_data['accesses'] = json_decode($group_data['accesses'], 1);
                $form->load($group_data);
                if (request()->post()) {
                    $form->load(request()->post());
                    $form->getValidationBuilder()->validate();
                    $return_data = $form->getReturnData();

                    BackendHelper::getRepositories()->updateUserGroup(
                        $group_id,
                        $return_data->getName(), json_encode($return_data->getAccesses()),
                        $return_data->getDescription()
                    );
                    return redirect()
                        ->route('users_interface.user_groups_info')
                        ->with(['successMessage' => 'Группа пользователя успешно обновлена']);
                }

                ViewManager::appendElement($form);
                return view('users_interface::user_groups.add_user_groups', ['title'=>'Изменение группы '.$group->name]);
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


