<?php
namespace App\Modules\Crm\schedule_plan\src;

use App\Modules\Crm\schedule_plan\src\SchedulePlanUnit;

class SchedulePlanEntity
{
    /** @var SchedulePlanUnit[] $schedule_units */
    private $schedule_units = [];

    public function addUnit(SchedulePlanUnit $unit)
    {
        $this->schedule_units[] = $unit;
    }


    /**
     * @return SchedulePlanUnit[]
     */
    public function getScheduleUnits()
    {
        return $this->schedule_units;
    }

    public function getScheduleUnitByData($number_week, $day_week, $pair_number)
    {
        foreach ($this->schedule_units as $unit) {
            if ($unit && $unit->getWeekNumber() == $number_week && $unit->getWeekDay() == $day_week && $unit->getPairId() == $pair_number) {
                return $unit;
            }
        }
        return null;
    }
}
