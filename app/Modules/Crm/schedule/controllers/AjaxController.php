<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\schedule\models\ScheduleManager;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class AjaxController extends Controller{


    public function scheduleManagerMenu()
    {
        $post = request()->post();
        $model = new ScheduleManager();
        $model->load($post);
        $validate = Validator::make($model->getData(), $model->rules());
        if ($validate->validate()) {
            request()->session()->put('schedule_manager_request', $model->getData());
            return view('schedule_manager.schedule_manager_menu');
        }
        abort(403, 'Ошибка валидации');
    }

    public function addScheduleManagerMenu()
    {
        $search_data = request()->session()->get('schedule_manager_request');
        if ($search_data) {

        }
        abort(500, 'Отсутствует search_data');
    }

}
