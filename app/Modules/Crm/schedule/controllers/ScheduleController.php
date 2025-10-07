<?php

namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use App\Src\modules\controllers\loaders\RmGroupLinkLoader;
use App\Src\modules\controllers\loaders\RmLink;
use App\Src\modules\controllers\RmGroupLoader;
use App\Src\modules\kernel\KernelModules;


class ScheduleController extends AbstractController
{

    static function loadController(KernelModules $kernel)
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
            ->RmLink('schedule_manager')
            ->setLink(route('schedule.schedule_manager'))
            ->setText('Менеджер расписаний');
    }

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
