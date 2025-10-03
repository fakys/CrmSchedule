<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Modules\Crm\users_interface\model\AddUser;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends AbstractController {
    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmGroupList('users_list')
            ->setText('Пользователи')
            ->setIcon('fa fa-user');

        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('users_list')
            ->RmLink('users')->setText('Пользователи')
            ->setLink(route('users_interface.users_info'));

        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('add_user')->setText('Добавить пользователя')
            ->setLink(route('users_interface.add_user'));
    }

    public function actionUsersInfo()
    {
        $search_data = request()->session()->has('search-user-info')
            ? request()->session()->get('search-user-info') : [];

        if (request()->method() == 'POST') {
            $data = BackendHelper::getRepositories()->getFullUsersInfoSearch(request()->post());
            if($search_data){
                request()->session()->forget('search-user-info');
            }
            request()->session()->put('search-user-info', request()->post());
            $search_data = request()->session()->get('search-user-info');
        } else {
            if (request()->session()->has('search-user-info')) {
                $data = BackendHelper::getRepositories()->getFullUsersInfoSearch($search_data);
            } else {
                $data = BackendHelper::getRepositories()->getFullUsersInfo();
            }
        }

        $users_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        return view('users.users_info', ['data' => $data, 'title'=>'Пользователи',
            'users_group'=>$users_group,
            'search_data'=>$search_data,
            'nav_users'=>true
        ]);
    }

    public function checkUserAccess()
    {
        $url = request()->post('links');
        return BackendHelper::getOperations()->hasAccessesByUrl($url);
    }

    public function actionAddUser()
    {
        $users_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        return view('users.add_user', ['users_group'=>$users_group, 'nav_operation'=>true]);
    }

    public function addUser()
    {
        if (request()->method() == 'POST') {
            $model = new AddUser();
            $model->load(request()->post());
            $validate = Validator::make($model->getData(), $model->rules());
            if($validate->validate() && $model->parseFio()){
                BackendHelper::getOperations()->addUser($model->getData());
            }
        }
        return redirect()->route('users_interface.users_info');
    }
}
