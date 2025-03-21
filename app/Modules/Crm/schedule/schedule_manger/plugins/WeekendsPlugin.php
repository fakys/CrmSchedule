<?php
namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\modules\plugins\AbstractPlugin;

/**
 * Плагин проставляющий выходные
 * @property ScheduleSearchData $searchData
 * @property Schedule $schedule
 * @property SemesterEntity $semesters
 * @property PairNumberEntity $pair_numbers
 * @property PlanScheduleEntity $planScheduleRepository
 */
class WeekendsPlugin extends AbstractPlugin
{

    public function pluginName()
    {
        return 'weekends_plugin';
    }

    public function Execute()
    {
        $settings = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName());
        $this->type_weeks = $settings->type_weeks;

        if ($this->schedule->getScheduleUnits()) {
            /** Устанавливаем выходные */
            foreach ($this->schedule->getScheduleUnits() as $schedule) {
                if ($this->type_weeks == ScheduleSetting::FIVE_DAY) {
                    if ($schedule->getDate()->format('w') == 6 || $schedule->getDate()->format('w') == 0) {
                        $schedule->setWeekday(true);
                    }
                } else {
                    if ($schedule->getDate()->format('w') == 0) {
                        $schedule->setWeekday(true);
                    }
                }
            }
            $this->setResult($this->schedule);
            return $this->schedule;
        }
    }
}
