<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Modules\Crm\users_interface\model\EditUserTabs;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class TabsController extends Controller{

    public function getUsersTableTabs()
    {
        return view('tabs.users_table_tabs');
    }

    public function getUserInfoTabs()
    {
        $data = [];
        if(isset(request()['id'])){
            $user = BackendHelper::getRepositories()->getUserById(request()['id']);
            $data = [
                'user'=>$user,
                'info'=>$user->getInfo(),
                'documents'=>$user->getDocument(),

            ];
        }
        return view('tabs.user_info_tabs', ['data' => $data]);
    }

    public function getEditUserInfoTabs()
    {
        $data = [];
        if(isset(request()['id'])){
            $user = BackendHelper::getRepositories()->getUserById(request()['id']);
            $data = [
                'user'=>$user,
                'info'=>$user->getInfo(),
                'documents'=>$user->getDocument(),

            ];
        }
        return view('tabs.edit_user_info_tabs', ['data' => $data]);
    }

    /**
     * Action обновления информации о пользователе
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setEditUserInfoTabs()
    {
        if(request()->post()){
            $model = new EditUserTabs();
            $model->load([request()->post()['field']=>isset(request()->post()['value'])?request()->post()['value']:'']);
            $validate = Validator::make($model->getData(), $model->rules());
            if($validate->validate() && $model->customValidate()) {
                if(isset(request()->post()['id'])&&$model->getData()){
                    return BackendHelper::getOperations()->UpdateFullUser(['id'=>request()->post()['id'],
                        'value'=>$model->getData()]);
                }
                return true;
            }elseif ($model->getErrors()){
                return 213213;
                abort(422, $model->getErrors()[request()->post()['field']]);
            }
        }
        abort(422, 'Ошибка обновления');
    }
}
