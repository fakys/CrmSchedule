<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Entity\UserInfo;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;

class UsersController extends Controller{

    public function actionUsersInfo()
    {
        $data = BackendHelper::getRepositories()->getFullUsersInfo();
        return view('users.users_info', ['data' => $data, 'title'=>'Пользователи']);
    }
}
