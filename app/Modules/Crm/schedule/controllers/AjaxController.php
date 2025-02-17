<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\schedule\models\ScheduleManagerModel;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{

    public function scheduleManagerMenu()
    {
        $model = new ScheduleManagerModel();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());

        if($validate->validate()){
            request()->session()->put('schedule_manager_request', $model->getData());
        }

        return view('schedule_manager.schedule_manager_menu', []);
    }

    public function addScheduleManagerMenu()
    {
        $searchData = request()->session()->get('schedule_manager_request');
        if (request()->post()) {
            $schedules = BackendHelper::getOperations()->getScheduleData($searchData);
            return view('schedule_manager.add_schedule', [
                'schedules' => $schedules
            ]);
        }

    }
}
