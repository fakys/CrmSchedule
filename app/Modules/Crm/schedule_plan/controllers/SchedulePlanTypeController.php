<?php
namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;
use App\Src\modules\controllers\loaders\RmGroupLinkLoader;
use App\Src\modules\controllers\loaders\RmLink;
use App\Src\modules\controllers\RmGroupLoader;
use Illuminate\Support\Facades\Validator;


class SchedulePlanTypeController extends AbstractController {

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->setText('РМ Преподавателя')
            ->setIcon('fa fa-graduation-cap')
            ->setAccess('rm_teachers_access');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('schedule_list')
            ->setName('schedule_list')
            ->setIcon('fa fa-list-alt')
            ->setText('Расписание')
            ->setAccess('schedule_list_access');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')->RmGroupList('schedule_list')
            ->RmLink('schedule_plan_type')
            ->setText('Типы плана расписания')
            ->setLink(route('schedule_plan.schedule_plan_types'));
    }

    public function actionSchedulePlanType()
    {
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        return view('schedule_plan::schedule_plan_type.index', ['title'=>'Тип плана расписания', 'types'=>$types, 'nav_schedule' => true]);
    }


    public function actionTypeSchedulePlanOperation()
    {
        $operation = request()->post('operation_name');
        switch ($operation) {
            case 'add_schedule_plan_type':
                return view('schedule_plan::schedule_plan_type.schedule_plan_type');
            default:
                if (preg_match('/\[(\d+)\]/', $operation, $matches) && isset($matches[1])) {
                    $type = BackendHelper::getRepositories()->getSchedulePlanTypeById($matches[1]);
                    return view('schedule_plan::schedule_plan_type.schedule_plan_type', ['type'=>$type]);
                }
                break;
        }
        abort(404);
    }


    public function formAddTypeSchedulePlan()
    {
        $five_day = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->type_weeks == ScheduleSetting::FIVE_DAY;
        $number_week = request()->post('number_week');
        $week_data = request()->post('week_data');
        return view('schedule_plan::schedule_plan_type.form_add', compact('five_day', 'number_week', 'week_data'));
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
