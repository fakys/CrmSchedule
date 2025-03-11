<?php
namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\modules\plugins\AbstractPlugin;

/**
 * Плагин назначающий каникулы
 * @property ScheduleSearchData $searchData
 * @property Schedule $schedule
 * @property SemesterEntity $semesters
 * @property PairNumberEntity $pair_numbers
 * @property PlanScheduleEntity $planScheduleRepository
 */
class HolidaysPlugin extends AbstractPlugin
{

    public function pluginName()
    {
        return 'holidays_plugin';
    }

    public function Execute()
    {
        if ($this->schedule) {

        }
    }
}
