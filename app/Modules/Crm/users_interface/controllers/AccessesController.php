<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;

class AccessesController extends AbstractController {

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('users_list')
            ->RmLink('access')->setText('Доступы')
            ->setLink(route('users_interface.accesses'));
    }

    public function actionAccesses()
    {
        $accesses = BackendHelper::getKernel()->getContext()->getAccesses();
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

        return view('users_interface::accesses.index', ['data'=>$data, 'title'=>'Все доступы', 'nav_users'=>true]);
    }
}
