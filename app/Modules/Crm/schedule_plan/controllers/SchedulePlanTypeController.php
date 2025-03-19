<?php
namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;


class SchedulePlanTypeController extends Controller{


    public function actionSchedulePlanType()
    {
        return view('schedule_plan_type.index', ['title'=>'План расписания']);
    }


    public function actionTypeSchedulePlanOperation()
    {
        $operation = request()->post('operation_name');
        switch ($operation) {
            case 'add_schedule_plan_type':
                return view('schedule_plan_type.schedule_plan_type_add');
            default:
                var_dump(12);
                break;
        }
        var_dump($operation);
    }


    public function formAddTypeSchedulePlan()
    {
        $five_day = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->type_weeks == ScheduleSetting::FIVE_DAY;
        $number_week = request()->post('number_week');
        return view('schedule_plan_type.form_add', compact('five_day', 'number_week'));
    }

    public function addSchedulePlanType()
    {

    }
}
