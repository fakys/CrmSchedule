<?php

namespace App\Modules\Crm\schedule_plan\controllers;

use App\Assets\LayoutBundle;
use App\Entity\User;
use App\Modules\Crm\schedule\components\tasks\CashScheduleTask;
use App\Modules\Crm\schedule_plan\assets\SchedulePlanAssets;
use App\Modules\Crm\schedule_plan\components\parse_schedule\ParseScheduleManager;
use App\Modules\Crm\schedule_plan\components\tasks\ParseSchedulePlanFile;
use App\Modules\Crm\schedule_plan\models\PairForm;
use App\Modules\Crm\schedule_plan\models\ScheduleCardModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanFileModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanModel;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\schedule_plan\src\ExcelPlanSchedule;
use App\Modules\Crm\schedule_plan\src\factories\SchedulePlanReturnDataFactory;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\AssetsBundle\Domain\Facades\AssetBundleManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\PeriodDatePicker;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class AjaxController extends AbstractController
{

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
    }

    static function assets(): array
    {
        return [];
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

    public function getConstructorSchedule()
    {
        $groups_id = request()->post('groups_id');
        $plan_type_id = request()->post('plan_type');
        $semester_id = request()->post('semester_id');
        $plan = BackendHelper::getRepositories()->getSchedulePlanTypeById($plan_type_id);
        $all_users_style = ArrayHelper::getColumn(\App\Src\BackendHelper::getRepositories()->allUsersStyle(), 'user_color', 'user_id');
        $data = [];
        foreach ($groups_id as $id) {
            $data[] = BackendHelper::getRepositories()->getStudentGroupById($id);
        }
        $pairs = BackendHelper::getRepositories()->getNumberPair();
        $week_days = SchedulePlanTypeModel::WEEK_DAYS;
        if (BackendHelper::getOperations()->getSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id)) {
            $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id);
        } else {
            $schedule_data = new SchedulePlanReturnData(
                $semester_id,
                $groups_id,
                $data[0]->specialty_id,
                $plan_type_id,
                BackendHelper::getOperations()->getPlanScheduleByGroupsCardFormatArray($groups_id, $semester_id)
            );
        }
        return view(
            'schedule_plan::schedule_plan.constructor_schedule',
            compact(
                'data',
                'week_days',
                'plan',
                'pairs',
                'schedule_data',
                'semester_id',
                'groups_id',
                'plan_type_id',
                'all_users_style',
            )
        );
    }

    public function getGroupInput()
    {
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id);
        $specialties_id = request()->post('specialties_id');
        $specialties = BackendHelper::getRepositories()->getSpecialtyById($specialties_id);
        $groups = ArrayHelper::getColumn($specialties->getGroups(), 'name', 'id');
        $plan_types = ArrayHelper::getColumn(BackendHelper::getRepositories()->allSchedulePlanType(), 'name', 'id');

        $select = new SelectSearch(
            'groups',
            $groups,
            new LabelAdditionalParams('Группы'),
            new SelectElementAdditionalParams(true, '', ['form-control', 'select_group'], (bool)$cash_data),
            $cash_data?->getGroupsId()
        );

        $plan_type = new SelectSearch(
            'plan_type',
            $plan_types,
            new LabelAdditionalParams('Тип недель'),
            new SelectElementAdditionalParams(false, '', ['form-control','plan_type'], (bool)$cash_data),
            $cash_data?->getPlanType()
        );
        ViewManager::appendElement($select);
        ViewManager::appendElement($plan_type);

        return view('schedule_plan::schedule_plan.group_input', compact('cash_data'));
    }

    public function getFormForPair()
    {
        $data = request()->post('data');
        $model = new ScheduleCardModel();
        $validator = Validator::make($data, $model->rules());
        $model->load($validator->validate());
        $entity = $model->toEntity();

        $form = new PairForm('form', new FormAdditionalParam(), $entity);
        ViewManager::appendElement($form);

        $card_id = $entity->getCardId();

        return view('schedule_plan::schedule_plan.pair_from', compact('data', 'card_id'));
    }

    public function setSchedulePlanCash()
    {
        $data = request()->post('data');
        BackendHelper::getOperations()->setSchedulePlanCash(SchedulePlanReturnDataFactory::createCashSchedulePlanReturnData(
            $data
        ));
        return json_encode(['result' => true]);
    }

    public function deleteSession()
    {
        BackendHelper::getOperations()->deleteSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id);
        return json_encode(['result' => true]);
    }

    public function getNewCardName()
    {
        $teacher = BackendHelper::getRepositories()->getUserById(request()->post('teacherId'));
        $color = '';
        if ($teacher->getStyle()) {
            $color = $teacher->getStyle()->user_color;
        }
        return json_encode(['result' =>
            [
                'cardName' => BackendHelper::getOperations()->cardName(request()->post('teacherId'), request()->post('subjectId')),
                'cardTime' => sprintf('%s - %s', request()->post('timeStart'), request()->post('timeEnd')),
                'color' => $color
            ]
        ]);
    }

    /** запускает таск для выгрузки */
    public function setPlanSchedule()
    {
        BackendHelper::taskCreate(
            'save_schedule_plan_file',
            [
                'userName' => BackendHelper::getKernel()->getContext()->getUser()->username
            ]
        );
    }

    /** Проверяет выполнился ли таск */
    public function checkStatusSaveSchedulePlanTask()
    {
        if (BackendHelper::getRepositories()->hasActiveTaskByUserName('save_schedule_plan_file', BackendHelper::getKernel()->getContext()->getUser()->username)) {
            return 'pending';
        }
        return 'none';
    }

    public function getSubjectInput()
    {
        $lessons = BackendHelper::getRepositories()->getLessonsByUser(request()->post('teacherId'));
        $subjects = [];

        foreach ($lessons as $lesson) {
            $subject = BackendHelper::getRepositories()->getSubjectById($lesson->subject_id);
            $subjects[$subject->id] = $subject->name;
        }

        $subject_select = new SelectSearch(
            'subjectId',
            $subjects,
            new LabelAdditionalParams('Предмет'),
            new SelectElementAdditionalParams(false, '', ['form-control', 'schedule-input']
            )
        );

        ViewManager::appendElement($subject_select);

        return view('schedule_plan::schedule_plan.subject_input');
    }

    public function validateCard()
    {
        //Обнуляем сообщение с ошибкой
        $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id);
        if ($schedule_data && $schedule_data->getErrorMessage()) {
            $schedule_data->setErrorMessage(null);
            BackendHelper::getOperations()->setSchedulePlanCash($schedule_data);
        }

        $model = new ScheduleCardModel();
        $validator = Validator::make(request()->post('card_data'), $model->rules());
        $model->load($validator->validate());

        $all_schedule_data = request()->post('all_schedule_data')??[];
        $data = BackendHelper::getOperations()->validateCard(
            $model->toEntity(),
            BackendHelper::getOperations()->convertDataToCardsEntities($all_schedule_data),
            request()->post('groups')
        );

        if ($data) {
            return json_encode(['result' => false, 'errors' => $data]);
        } else {
            return json_encode(['result' => true, 'errors' => $data]);
        }
    }

    public function downloadScheduleFile()
    {

        $model = new SchedulePlanFileModel();
        $model->load(request()->all());
        $validate = Validator::make($model->getData(), $model->rules());
        $file = request()->file('file');
        if ($validate->validate()) {
            //Обнуляем сообщение с ошибкой
            $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id);
            if ($schedule_data && $schedule_data->getErrorMessage()) {
                $schedule_data->setErrorMessage(null);
                BackendHelper::getOperations()->setSchedulePlanCash($schedule_data);
            }

            BackendHelper::taskCreate(
                'parse_schedule_plan_file',
                [
                    'plan_type' => $model->plan_type,
                    'groups' => $model->groups,
                    'semester' => $model->semester,
                    'file_path' => Storage::disk('local')->putFileAs('private/runtime', $file, ParseSchedulePlanFile::FILE_NAME),
                    'userName' => BackendHelper::getKernel()->getContext()->getUser()->username
                ]);
        }
    }

    public function checkStatusSchedulePlanCron()
    {
        if (BackendHelper::getRepositories()->hasActiveTaskByUserName('parse_schedule_plan_file', BackendHelper::getKernel()->getContext()->getUser()->username)) {
            return 'pending';
        }
        return 'none';
    }
}
