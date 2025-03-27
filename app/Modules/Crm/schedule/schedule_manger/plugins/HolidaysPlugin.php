<?php
namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\HolidayEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\BackendHelper;
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
        $holiday_setting = BackendHelper::getSystemSettings('holiday_settings');
        if ($this->schedule) {
            if ($holiday_setting->use_settings) {
                foreach ($this->schedule->getScheduleUnits() as $unit) {
                    foreach ($holiday_setting->holidays as $number_holiday => $holiday) {
                        $holiday_start = new \DateTime();
                        $holiday_end = new \DateTime();

                        $pace_period = explode(' - ', $holiday['period']);
                        $pace_date_start = explode('.', trim($pace_period[0]));
                        $pace_date_end = explode('.', trim($pace_period[1]));
                        $holiday_start->setDate($unit->getDate()->format('Y'), trim($pace_date_start[0]), trim($pace_date_start[1]));
                        $holiday_end->setDate($unit->getDate()->format('Y'), trim($pace_date_end[0]), trim($pace_date_end[1]));
                        if ($unit->getDate()->format('Y-m-d') >= $holiday_start->format('Y-m-d') && $unit->getDate()->format('Y-m-d') <= $holiday_end->format('Y-m-d')) {
                            $unit->setHoliday($this->createHoliday($holiday, $holiday_start, $holiday_end));
                        }
                    }
                }
            }
        }
    }


    /**
     * @param array $holiday_data
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     * @return HolidayEntity
     */
    public function createHoliday($holiday_data, $date_start, $date_end)
    {
        $holiday = new HolidayEntity();
        $holiday->setHolidayName($holiday_data['name']);
        $holiday->setHolidayDescription($holiday_data['description']);
        $holiday->setHolidayFormatType($holiday_data['format']);
        $holiday->setHolidayDateStart($date_start);
        $holiday->setHolidayDateEnd($date_end);
        return $holiday;
    }


}
