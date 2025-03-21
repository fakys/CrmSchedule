<?php

namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule_plan\models\SchedulePlanModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SchedulePlanController extends Controller
{


    public function actionSchedulePlan()
    {
        return view('schedule_plan.index', ['title' => 'Плана расписания']);
    }

    public function addSchedulePlan()
    {
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        $groups = BackendHelper::getRepositories()->getFullStudentGroups();
        $semesters = BackendHelper::getRepositories()->getAllSemesters();
        return view('schedule_plan.add_schedule_plan', [
            'title' => 'Добавить плана расписания',
            'types' => $types,
            'groups' => $groups,
            'semesters' => $semesters
        ]);
    }

    public function addPlanScheduleForm()
    {
        $plan_type_id = request()->post('plan_type_id');
        $plan_type = BackendHelper::getRepositories()->getSchedulePlanTypeById($plan_type_id);
        $weeks = BackendHelper::getOperations()->formatWeeks($plan_type->getWeeks());
        $users = BackendHelper::getRepositories()->getUserList([]);
        $pair_format = BackendHelper::getRepositories()->getFullFormatLessons();
        $pair_number = BackendHelper::getRepositories()->getNumberPair();
        $subjects = BackendHelper::getRepositories()->getFullSubject();
        $week_days = SchedulePlanTypeModel::WEEK_DAYS;
        return view('schedule_plan.add_schedule_plan_form', compact('weeks', 'subjects', 'users', 'pair_format', 'pair_number', 'week_days'));
    }

    public function savePlanSchedule()
    {
        $model = new SchedulePlanModel();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate() && $model->validatePlan()){
            BackendHelper::getOperations()->addSchedulePlan($model->schedule_data, $model->group_id, $model->type_id, $model->semester_id);
        }
        return 1;
    }
}
