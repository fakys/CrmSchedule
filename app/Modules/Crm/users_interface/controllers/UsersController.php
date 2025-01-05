<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Entity\UserInfo;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;

class UsersController extends Controller{

    public function actionUsersInfo()
    {
        if(request()->method() == 'POST'){
            $data = BackendHelper::getRepositories()->getFullUsersInfoSearch(request()->post());
        }else{
            $data = BackendHelper::getRepositories()->getFullUsersInfo();
        }

        $users_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        return view('users.users_info', ['data' => $data, 'title'=>'Пользователи', 'users_group'=>$users_group]);
    }

    public function checkUserAccess()
    {
        $url = request()->post('links');
        return BackendHelper::getOperations()->hasAccessesByUrl($url);
    }
}
