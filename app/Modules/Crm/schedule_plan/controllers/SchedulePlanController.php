<?php

namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule\tasks\CashScheduleTask;
use App\Modules\Crm\schedule_plan\models\SchedulePlanModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\redis\RedisManager;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SchedulePlanController extends Controller
{

    /**
     * Проверяет поля при заполнении в конструкторе
     */
    public function validateScheduleFields()
    {
        $semester_id = request()->input('semester_id');
        $pair_data = request()->input('pair_data');
        $exception = request()->input('exception');
        BackendHelper::getOperations()->validateFieldPlan($pair_data, $semester_id, $exception);
    }

    public function actionSchedulePlan()
    {
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        $groups = BackendHelper::getRepositories()->getFullStudentGroups();
        $semesters = BackendHelper::getRepositories()->getAllSemesters();
        $specialties = BackendHelper::getRepositories()->getAllSpecialties();
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id);
        return view('schedule_plan.index', [
            'title' => 'Плана расписания',
            'types' => $types,
            'cash_data' => $cash_data,
            'groups' => $groups,
            'semesters' => $semesters,
            'specialties' => ArrayHelper::getColumn($specialties, 'name', 'id'),
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

    public function getConstructorSchedule()
    {
        $groups_id = request()->post('groups_id');
        $plan_type_id = request()->post('plan_type');
        $plan = BackendHelper::getRepositories()->getSchedulePlanTypeById($plan_type_id);
        $data = [];
        foreach ($groups_id as $id) {
            $data[] = BackendHelper::getRepositories()->getStudentGroupById($id);
        }
        $pairs = BackendHelper::getRepositories()->getNumberPair();
        $week_days = SchedulePlanTypeModel::WEEK_DAYS;
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id);
        return view('schedule_plan.constructor_schedule', compact('data', 'week_days', 'plan', 'pairs', 'cash_data'));
    }

    public function getGroupInput()
    {
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id);
        $specialties_id = request()->post('specialties_id');
        $specialties = BackendHelper::getRepositories()->getSpecialtyById($specialties_id);
        $groups = ArrayHelper::getColumn($specialties->getGroups(), 'name', 'id');
        $plan_types = ArrayHelper::getColumn(BackendHelper::getRepositories()->allSchedulePlanType(), 'name', 'id');
        return view('schedule_plan.group_input', compact('groups', 'plan_types', 'cash_data'));
    }

    public function getFormForPair()
    {
        $data = request()->post('data');
        $card_id = request()->post('card_id');
        $users_obj = BackendHelper::getRepositories()->getAllTeachers();
        $users = [];
        $subject = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullSubject(), 'name', 'id');
        foreach ($users_obj as $user) {
            $users[$user->id] = $user->getFio();
        }

        return view('schedule_plan.pair_from', compact('data', 'users', 'subject', 'card_id'));
    }

    public function setSchedulePlanCash()
    {
        $data = request()->post('data');
        BackendHelper::getOperations()->setSchedulePlanCash($data);
        return json_encode(['result'=>true]);
    }

    public function deleteSession()
    {
        $data = request()->post('data');
        BackendHelper::getOperations()->setSchedulePlanCash($data);
        return json_encode(['result'=>true]);
    }

    public function getNewCardName()
    {
        $teacher = BackendHelper::getRepositories()->getUserById(request()->post('user'));
        $subject = BackendHelper::getRepositories()->getSubjectById(request()->post('subject'));
        return json_encode(['result'=>['card_name'=>sprintf('%s - %s', $teacher->getMinFio(), $subject->name)]]);
    }

    public function validateCard()
    {
        $card_data = request()->post('card_data');
        $all_schedule_data = request()->post('all_schedule_data');
        $data = BackendHelper::getOperations()->validateCard($card_data, $all_schedule_data);

        if ($data) {
            return json_encode(['result'=>false, 'errors' => $data]);
        } else {
            return json_encode(['result'=>true, 'errors' => $data]);
        }
    }
}
