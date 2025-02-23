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
        if (request()->post() && $searchData) {
            $schedules = BackendHelper::getOperations()->getScheduleData($searchData);
            $subjects = BackendHelper::getRepositories()->getFullSubject();
            $pair_number = BackendHelper::getRepositories()->getNumberPair();
            $users = BackendHelper::getRepositories()->getUserList([]);
            $pair_format = BackendHelper::getRepositories()->getFullFormatLessons();
            $student_groups = BackendHelper::getRepositories()->getFullStudentGroups();

            return view('schedule_manager.add_schedule', [
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

    public function editScheduleManager()
    {
        $searchData = request()->session()->get('schedule_manager_request');
        $new_schedule = request()->post('schedule');
        $model = new ScheduleManagerModel();
        if ($new_schedule && $searchData) {
            BackendHelper::getOperations()->editSchedule($model->deleteEmptySchedule($new_schedule), $searchData);
            return 213213;
        }
        abort(500, 'Отсутствуют обязательные параметры');
    }
}
