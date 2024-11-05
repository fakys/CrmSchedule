<?php
namespace App\Modules\Crm\interface\controllers;

use Illuminate\Routing\Controller;
use App\Modules\Crm\interface\InfoModule;


class UsersInterfaceController extends Controller
{
    public function __construct()
    {
        (new InfoModule())->runConfig();
    }

    public function actionUsers()
    {
        $fields = [
            'login'=>'Логин',
            'first_name'=>'Имя',
            'last_name'=>'Фамилия',
            'patronymic'=>'Отчество',
            'email'=>'Email',
        ];
        $data = [
            [
                'login'=>'Логин',
                'first_name'=>'Имя',
                'last_name'=>'Фамилия',
                'patronymic'=>'Отчество',
                'email'=>'Email',
            ]
        ];
        return view('users/users', compact('fields', 'data'));
    }
}
