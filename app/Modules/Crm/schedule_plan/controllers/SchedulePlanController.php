<?php

namespace App\Modules\Crm\schedule_plan\controllers;

use App\Modules\Crm\schedule_plan\assets\SchedulePlanAssets;
use App\Services\AssetsBundle\Domain\Facades\AssetBundleManager;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;


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

    static function assets(): array
    {
        return [];
    }

    public function actionSchedulePlan()
    {
        AssetBundleManager::appendBundle(new SchedulePlanAssets());
        $types = BackendHelper::getRepositories()->allSchedulePlanType();
        $groups = BackendHelper::getRepositories()->getFullStudentGroups();
        $semesters = BackendHelper::getRepositories()->getSemestersQuery()->orderBy('id', 'desc')->get();
        $specialties = BackendHelper::getRepositories()->getAllSpecialties();
        $cash_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(BackendHelper::getKernel()->getContext()->getUser()->id);
        return view('schedule_plan::schedule_plan.index', [
            'title' => 'План расписания',
            'types' => $types,
            'cash_data' => $cash_data,
            'groups' => $groups,
            'semesters' => $semesters,
            'specialties' => ArrayHelper::getColumn($specialties, 'name', 'id'),
            'nav_schedule' => true
        ]);
    }
}
