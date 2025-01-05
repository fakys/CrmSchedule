<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Modules\Crm\users_interface\model\UserAddGroups;
use App\Modules\Crm\users_interface\model\EditUserTabs;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;

class AccessesController extends Controller{


    public function actionAccesses()
    {
        $accesses = context()->getAccesses();
        $data = [];
        for ($i = 0; $i < count($accesses); $i++) {
            $data[$i] = [
                'id' => $i + 1,
                'name' => $accesses[$i]->getAccess(),
            ];
            if ($accesses[$i]->getRoute() && $accesses[$i]->getRoute()->getName()){
                $data[$i]['url'] = route($accesses[$i]->getRoute()->getName());
            }else{
                $data[$i]['url'] = 'Нет данных';
            }

            if ($accesses[$i]->getDescription()){
                $data[$i]['description'] = $accesses[$i]->getDescription();
            }else{
                $data[$i]['description'] = 'Нет данных';
            }
        }

        return view('accesses.index', ['data'=>$data, 'title'=>'Все доступы']);
    }
}
