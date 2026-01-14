<?php

namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule\tasks\CashScheduleTask;
use App\Modules\Crm\schedule_plan\models\SchedulePlanModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\schedule_plan\src\ExcelPlanSchedule;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use App\Src\modules\controllers\loaders\RmGroupLinkLoader;
use App\Src\modules\controllers\loaders\RmLink;
use App\Src\modules\controllers\RmGroupLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class SchedulePlanController extends AbstractController
{

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
            ->RmLink('schedule_plan')
            ->setText('План на семестр (По группам)')
            ->setLink(route('schedule_plan.schedule_plan'));
    }

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
        return view('schedule_plan::schedule_plan.index', [
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
        return view('schedule_plan::schedule_plan.type_schedule_plan_form', ['types' => $types]);
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
        $semester_id = request()->post('semester_id');
        $plan = BackendHelper::getRepositories()->getSchedulePlanTypeById($plan_type_id);
        $data = [];
        foreach ($groups_id as $id) {
            $data[] = BackendHelper::getRepositories()->getStudentGroupById($id);
        }
        $pairs = BackendHelper::getRepositories()->getNumberPair();
        $week_days = SchedulePlanTypeModel::WEEK_DAYS;
        $schedule_data_db = BackendHelper::getRepositories()->getPlanScheduleByGroups($groups_id, $semester_id);
        $schedule_data = null;
        if (BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id)) {
            $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id);
        } elseif ($schedule_data_db) {
            $schedule_data = SchedulePlanReturnData::cardCacheFormat($schedule_data_db);
        }

        return view('schedule_plan::schedule_plan.constructor_schedule', compact('data', 'week_days', 'plan', 'pairs', 'schedule_data'));
    }

    public function getGroupInput()
    {
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id);
        $specialties_id = request()->post('specialties_id');
        $specialties = BackendHelper::getRepositories()->getSpecialtyById($specialties_id);
        $groups = ArrayHelper::getColumn($specialties->getGroups(), 'name', 'id');
        $plan_types = ArrayHelper::getColumn(BackendHelper::getRepositories()->allSchedulePlanType(), 'name', 'id');
        return view('schedule_plan::schedule_plan.group_input', compact('groups', 'plan_types', 'cash_data'));
    }

    public function getFormForPair()
    {
        $data = request()->post('data');
        $card_id = request()->post('card_id');
        $users_obj = BackendHelper::getRepositories()->getAllTeachers();
        $users = [];
        $subject = [];
        $formats = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullFormatLessons(), 'name', 'id');
        $format = $data['format']??null;

        if ($data['user'] && $data['subject']) {
            foreach (BackendHelper::getRepositories()->getLessonsByUser($data['user']) as $lesson) {
                $sub = BackendHelper::getRepositories()->getSubjectById($lesson->subject_id);
                $subject[$sub->id] = $sub->name;
            }
        }

        foreach ($users_obj as $user) {
            $users[$user->id] = $user->getFio();
        }

        return view('schedule_plan::schedule_plan.pair_from', compact('data', 'users', 'subject', 'card_id', 'formats', 'format'));
    }

    public function setSchedulePlanCash()
    {
        $data = request()->post('data');
        BackendHelper::getOperations()->setSchedulePlanCash($data);
        return json_encode(['result'=>true]);
    }

    public function deleteSession()
    {
        BackendHelper::getOperations()->deleteSchedulePlanCashByUserId(context()->getUser()->id);
        return json_encode(['result'=>true]);
    }

    public function getNewCardName()
    {
        $teacher = BackendHelper::getRepositories()->getUserById(request()->post('user'));
        $color = '';
        if ($teacher->getStyle()) {
            $color = $teacher->getStyle()->user_color;
        }
        return json_encode(['result'=>
            [
                'card_name'=>BackendHelper::getOperations()->cardName(request()->post('user'), request()->post('subject')),
                'card_time' => sprintf('%s - %s', request()->post('time_start'), request()->post('time_end')),
                'color' => $color
            ]
        ]);
    }

    public function setPlanSchedule()
    {
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(context()->getUser()->id);

        if ($cash_data) {
            if (BackendHelper::getRepositories()->getPlanScheduleByGroups($cash_data['groups'], $cash_data['semester'])) {
                BackendHelper::getRepositories()->deletePlanScheduleByGroups($cash_data['groups'], $cash_data['semester']);
            }
            DB::beginTransaction();
            foreach ($cash_data['schedule_data'] as $card_data) {
                BackendHelper::getOperations()->saveSchedulePlan($card_data);
            }
            DB::commit();
        }
        BackendHelper::getOperations()->deleteSchedulePlanCashByUserId(context()->getUser()->id);
    }

    public function getSubjectInput()
    {
        $lessons = BackendHelper::getRepositories()->getLessonsByUser(request()->post('teacher'));
        $subjects = [];

        foreach ($lessons as $lesson) {
            $subject = BackendHelper::getRepositories()->getSubjectById($lesson->subject_id);
            $subjects[$subject->id] = $subject->name;
        }

        return view('schedule_plan::schedule_plan.subject_input', compact('subjects'));
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

    public function downloadTemplate()
    {
        $groups = BackendHelper::getRepositories()->getStudentGroupByQuery(
            ['id', explode(',', request()->get('select_group'))],
        );
        dd($groups);
        return Excel::download(new ExcelPlanSchedule(
            $groups->toArray(),
            $types[0]
        ), 'schedule.xlsx');
    }
}
