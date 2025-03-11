<?php
namespace App\Modules\Crm\schedule\src\schedule_manager;

class Schedule
{
    /** @var ScheduleUnit[] $schedule_units */
    private $schedule_units = [];

    public function addUnit(ScheduleUnit $unit)
    {
        $this->schedule_units[] = $unit;
    }


    public function getScheduleUnits()
    {
        return $this->schedule_units;
    }

    /**
     * @param \DateTime $date
     * @return ScheduleUnit[]
     */
    public function getScheduleUnitByDate(\DateTime $date)
    {
        $units_by_date = [];
        foreach ($this->schedule_units as $unit) {
            if ($unit->getDate() === $date) {
                $units_by_date[] = $unit;
            }
        }
        return $units_by_date;
    }
}
