<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\schedule\exceptions\ScheduleEditValidException;
use App\Modules\Crm\schedule\models\EditScheduleModel;
use App\Modules\Crm\schedule\models\ScheduleManagerModel;
use App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule\ScheduleManagerReturnData;
use App\Modules\Crm\schedule\tasks\CashScheduleTask;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
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

        return view('schedule::schedule_manager.schedule_manager_menu', []);
    }

    public function addScheduleManagerMenu()
    {

        $searchData = request()->session()->get('schedule_manager_request');
        if (request()->post() && $searchData) {
            $manager = BackendHelper::getManager('schedule_manger')->Execute();
            $schedules = (new ScheduleManagerReturnData($manager->getResult()))->getSchedule();
            $subjects = BackendHelper::getRepositories()->getFullSubject();
            $pair_number = BackendHelper::getRepositories()->getNumberPair();
            $users = BackendHelper::getRepositories()->getAllTeachers();
            $pair_format = BackendHelper::getRepositories()->getFullFormatLessons();
            $student_groups = BackendHelper::getRepositories()->getFullStudentGroups();
            $use_cash = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->cash_schedule;
            return view('schedule::schedule_manager.add_schedule', [
                'schedules' => $schedules,
                'subjects' => $subjects,
                'pair_number' => $pair_number,
                'users' => $users,
                'pair_format' => $pair_format,
                'student_groups' => $student_groups,
                'use_cash' => $use_cash
            ]);
        }
        abort(500, 'Ошибка сервера');
    }

    /**
     * @throws ScheduleEditValidException
     */
    public function editScheduleManager()
    {
        try {
            $model = new EditScheduleModel();
            $model->load(request()->post());
            if ($model->schedule) {
                if ($model->validate()) {
                    BackendHelper::getOperations()->editSchedule($model->schedule);
                    if (BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->cash_schedule) {
                        BackendHelper::taskCreate(CashScheduleTask::TASK_NAME);
                    }
                    return true;
                }
            }
        } catch (ScheduleEditValidException $exp) {
            return view('schedule::schedule_manager.error_page', ['error_schedule'=>$model->error_schedule]);
        }

        abort(500, 'Отсутствуют обязательные параметры');
    }

    /**
     * Проверяет активен ли таск кеширования
     * @return bool
     */
    public function checkCashScheduleTask()
    {
        return (bool)BackendHelper::getRepositories()->hasActiveTask(CashScheduleTask::TASK_NAME);
    }


    public function hasScheduleManagerMenu()
    {
        $searchData = request()->session()->get('schedule_manager_request');
        if (request()->post() && $searchData) {
            $manager = BackendHelper::getManager('schedule_manger')->Execute();
            $schedules = (new ScheduleManagerReturnData($manager->getResult()))->getSchedule();
            $subjects = BackendHelper::getRepositories()->getFullSubject();
            $pair_number = BackendHelper::getRepositories()->getNumberPair();
            $users = BackendHelper::getRepositories()->getAllTeachers();
            $pair_format = BackendHelper::getRepositories()->getFullFormatLessons();
            $student_groups = BackendHelper::getRepositories()->getFullStudentGroups();
            return view('schedule::schedule_manager.has_schedule', [
                'schedules' => $schedules,
                'subjects' => $subjects,
                'pair_number' => $pair_number,
                'users' => $users,
                'pair_format' => $pair_format,
                'student_groups' => $student_groups,
            ]);
        }
        abort(500, 'Ошибка сервера');
    }
}
