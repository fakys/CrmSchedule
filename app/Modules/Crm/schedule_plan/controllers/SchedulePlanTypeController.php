<?php
namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SchedulePlanTypeController extends Controller{


    public function actionSchedulePlanType()
    {
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        return view('schedule_plan_type.index', ['title'=>'Тип плана расписания', 'types'=>$types]);
    }


    public function actionTypeSchedulePlanOperation()
    {
        $operation = request()->post('operation_name');
        switch ($operation) {
            case 'add_schedule_plan_type':
                return view('schedule_plan_type.schedule_plan_type');
            default:
                if (preg_match('/\[(\d+)\]/', $operation, $matches) && isset($matches[1])) {
                    $type = BackendHelper::getRepositories()->getSchedulePlanTypeById($matches[1]);
                    return view('schedule_plan_type.schedule_plan_type', ['type'=>$type]);
                }
                break;
        }
        var_dump($operation);
    }


    public function formAddTypeSchedulePlan()
    {
        $five_day = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->type_weeks == ScheduleSetting::FIVE_DAY;
        $number_week = request()->post('number_week');
        $week_data = request()->post('week_data');
        return view('schedule_plan_type.form_add', compact('five_day', 'number_week', 'week_data'));
    }

    public function addSchedulePlanType()
    {
        $data = request()->post();
        $model = new SchedulePlanTypeModel();
        $model->load($data);
        $validate = Validator::make($model->getData(), $model->rules());
        if ($validate->validate()) {
            return BackendHelper::getOperations()->addSchedulePlanType($model->getData());
        }
        return false;
    }


    public function editSchedulePlanType()
    {
        $data = request()->post();
        $id  = request()->post('id');
        $model = new SchedulePlanTypeModel();
        $model->load($data);
        $validate = Validator::make($model->getData(), $model->rules());
        if ($validate->validate()) {
            return BackendHelper::getRepositories()->editSchedulePlanTypeById($id, $model->name, $model->data);
        }
        return false;
    }

    public function deleteWeekSchedulePlanType()
    {
        $id  = request()->post('id');
        $number = request()->post('number');
        if ($id && $number) {
            $type = BackendHelper::getRepositories()->getSchedulePlanTypeById($id);
            $data = $type->getWeeks();
            unset($data[$number]);
            $plan_type_data_arr = json_decode($type->plan_type_data, 1);
            $plan_type_data_arr['weeks'] = array_values($data);
            $newKeys = array_map(fn($key) => $key + 1, array_keys($plan_type_data_arr['weeks']));
            $plan_type_data_arr['weeks'] = array_combine($newKeys, $plan_type_data_arr['weeks']);
            return BackendHelper::getRepositories()->editSchedulePlanTypeById($id, $type->name, $plan_type_data_arr);
        }
    }
}
