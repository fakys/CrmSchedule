<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Src\BackendHelper;
use Illuminate\Routing\Controller;

class TabsController extends Controller{

    public function getUsersTableTabs()
    {
        return view('tabs.users_table_tabs');
    }

    public function getUserInfoTabs()
    {
        $data = [];
        if(isset(request()['id'])){

        }
        $user = BackendHelper::getRepositories()->getUserById(1);
        $data = [
            'user'=>$user,
            'info'=>$user->getInfo(),
            'documents'=>$user->getDocument(),

        ];
        return view('tabs.user_info_tabs', ['data' => $data]);
    }
}
