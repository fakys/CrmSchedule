<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\Schedule;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use DateTime;

class ChangeScheduleEntity
{
    private $schedules = [];

    /**
     * @param Schedule[] $schedules
     */
    public function __construct($schedules)
    {
        foreach ($schedules as $schedule) {
            $this->schedules[$schedule->student_group_id]
            [date('Y-m-d', strtotime($schedule->getDuration()->date_start))]
            [$schedule->getPairNumber()->number] = $schedule;
        }
    }


    public function getScheduleByData($studentGroupId, DateTime $date, $pairNumber)
    {
        return $this->schedules[$studentGroupId][$date->format('Y-m-d')][$pairNumber] ?? null;
    }
}
