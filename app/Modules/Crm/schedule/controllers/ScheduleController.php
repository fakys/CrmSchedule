<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;


class ScheduleController extends Controller{


    public function actionScheduleManager()
    {
        $student_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullStudentGroups(), 'name', 'id');
        $specialties = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id');
        $session_data = request()->session()->get('schedule_manager_request');
        $setting_weekend = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->type_weeks;

        return view('schedule_manager.index', [
            'title' => 'Менеджер расписаний',
            'student_group' => $student_group,
            'specialties' => $specialties,
            'session_data' => $session_data,
            'setting_weekend' => $setting_weekend,
            'nav_schedule' => true
        ]);
    }

}
