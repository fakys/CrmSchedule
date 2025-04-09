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


    /**
     * @return ScheduleUnit[]
     */
    public function getScheduleUnits()
    {
        return $this->schedule_units;
    }

    /**
     * @param \DateTime $date
     * @param $group_id
     * @return ScheduleUnit[]
     */
    public function getScheduleUnitByDate(\DateTime $date, $group_id)
    {
        $units_by_date = [];
        foreach ($this->schedule_units as $unit) {
            if ($unit->getDate() == $date && $unit->getGroup() == $group_id) {
                $units_by_date[] = $unit;
            }
        }
        return $units_by_date;
    }

    /**
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     * @return ScheduleUnit[]
     *
     */
    public function getScheduleUnitsByPeriod($date_start, $date_end, $group_id)
    {
        $units = [];
        foreach ($this->schedule_units as $unit) {
            if ($unit->getDate() >= $date_start && $unit->getDate() <= $date_end && $unit->getGroup() == $group_id) {
                $units[] = $unit;
            }
        }

        return $units;
    }
}
