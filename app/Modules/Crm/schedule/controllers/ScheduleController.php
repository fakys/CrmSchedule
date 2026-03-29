<?php

namespace App\Modules\Crm\schedule\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\schedule\assets\ScheduleManagerAssets;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\PeriodDatePicker;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
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

    static function assets(): array
    {
        return [
            ScheduleManagerAssets::class
        ];
    }

    public function actionScheduleManager()
    {
        $student_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullStudentGroups(), 'name', 'id');
        $specialties = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id');
        $session_data = request()->session()->get('schedule_manager_request');
        $setting_weekend = BackendHelper::getSystemSettings(ScheduleSetting::SETTING_NAME)->type_weeks;

        $period_element = new PeriodDatePicker('period', new LabelAdditionalParams('Период'), new FormElementAdditionalParams());
        $groups_element = new SelectSearch('groups',$student_group, new LabelAdditionalParams('Группы'), new SelectElementAdditionalParams(true, '', ['student_groups', 'form-control']));
        $specialties_element = new SelectSearch('specialties', $specialties, new LabelAdditionalParams('Специальности'), new SelectElementAdditionalParams(true, '', ['specialties', 'form-control']));
        ViewManager::appendElement($period_element);
        ViewManager::appendElement($groups_element);
        ViewManager::appendElement($specialties_element);

        return view('schedule::schedule_manager.index', [
            'title' => 'Менеджер расписаний',
            'student_group' => $student_group,
            'specialties' => $specialties,
            'session_data' => $session_data,
            'setting_weekend' => $setting_weekend,
            'nav_schedule' => true
        ]);
    }

}
