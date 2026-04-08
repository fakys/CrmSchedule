<?php

namespace App\Modules\Crm\schedule\components\schedule_manger;

use App\Modules\Crm\schedule\components\schedule_manger\plugins\abstracts\AbstractSchedulePlugin;
use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\ChangeScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule\ScheduleManagerReturnData;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\plugins\mangers\AbstractManger;

/** Менеджер возвращает расписание */
class ScheduleManger extends AbstractManger
{
    public function getName(): string
    {
        return 'schedule_manger';
    }

    public function constrictSchedule(array $searchData): ScheduleManagerReturnData
    {
        /** @var AbstractSchedulePlugin[] $plugins */
        $plugins = $this->getPlugins();
        $index_plugins = [];
        $searchData = new ScheduleSearchData($searchData);
        /** Сначала сортируем */
        foreach ($plugins as $plugin) {
            $index_plugins[$plugin->index()*100] = $plugin;
        }

        $schedule = new Schedule();
        foreach ($index_plugins as $index => $plugin) {
            $plugin->setSearchData($searchData);
            $plugin->setSchedule($schedule);
            $plugin->setPairNumbers(new PairNumberEntity(
                BackendHelper::getRepositories()->getNumberPair()
            ));
            $plugin->setSemester(
                new SemesterEntity(BackendHelper::getRepositories()->getSemestersByPeriod($searchData->getDateStart(), $searchData->getDateEnd()))
            );
            $plugin->setSchedulePlan(
                new PlanScheduleEntity($this->getSchedulePlan(ArrayHelper::getColumn($plugin->getSemesters()->getSemesters(), 'id'), $searchData->getGroupsId()))
            );

            $plugin->setChangeScheduleEntity(new ChangeScheduleEntity(
                BackendHelper::getRepositories()->getCorrectionScheduleByGroupAndDate($searchData->getGroupsId(), $searchData->getDateStart()->format('Y-m-d'), $searchData->getDateEnd()->format('Y-m-d'))
            ));
            $plugin->Execute();
        }
        return new ScheduleManagerReturnData($schedule);
    }

    private function getSchedulePlan(array $semesters_id, array $groups_id)
    {
        $data = [];
        foreach ($semesters_id as $semester_id) {
            foreach (BackendHelper::getRepositories()->getPlanScheduleByGroups($groups_id, $semester_id) as $planSchedule) {
                $data[] = $planSchedule;
            }
        }
        return $data;
    }
}
