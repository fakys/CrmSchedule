<?php

namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule\tasks\CashScheduleTask;
use App\Modules\Crm\schedule_plan\models\SchedulePlanModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SchedulePlanController extends Controller
{


    public function actionSchedulePlan()
    {
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        $groups = BackendHelper::getRepositories()->getFullStudentGroups();
        $semesters = BackendHelper::getRepositories()->getAllSemesters();
        return view('schedule_plan.index', [
            'title' => 'Плана расписания',
            'types' => $types,
            'groups' => $groups,
            'semesters' => $semesters,
            'nav_schedule' => true
        ]);
    }

    public function checkSchedulePlan()
    {
        $semester_id = request()->post('semester_id');
        $group_id = request()->post('group_id');

        $first_plan = BackendHelper::getRepositories()->getFirstPlanSchedule($group_id, $semester_id);
        if ($first_plan) {
            return $first_plan->plan_type_id;
        } else {
            return false;
        }
    }

    public function getTypeSchedulePlanForm()
    {
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        return view('schedule_plan.type_schedule_plan_form', ['types' => $types]);
    }

    public function addPlanScheduleForm()
    {
        $plan_type_id = request()->post('plan_type_id');
        $manager = BackendHelper::getManager('schedule_plan_manager');
        $manager->setAttr(request()->post());
        $manager->Execute();
        $schedule_plan_data = $manager->getResult();
        $plan_type = BackendHelper::getRepositories()->getSchedulePlanTypeById($plan_type_id);
        $weeks = BackendHelper::getOperations()->formatWeeks($plan_type->getWeeks());
        $users = BackendHelper::getRepositories()->getUserList([]);
        $pair_format = BackendHelper::getRepositories()->getFullFormatLessons();
        $pair_number = BackendHelper::getRepositories()->getNumberPair();
        $subjects = BackendHelper::getRepositories()->getFullSubject();
        $week_days = SchedulePlanTypeModel::WEEK_DAYS;
        return view('schedule_plan.add_schedule_plan_form', compact('weeks', 'subjects', 'users', 'pair_format', 'pair_number', 'week_days', 'schedule_plan_data'));
    }

    public function savePlanSchedule()
    {
        $model = new SchedulePlanModel();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate() && $model->validatePlan()){
            if (BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->cash_schedule) {
                BackendHelper::taskCreate(CashScheduleTask::TASK_NAME);
            }
            BackendHelper::getOperations()->addSchedulePlan($model->schedule_data, $model->group_id, $model->semester_id, $model->type_id);
        }
        return 1;
    }
}
