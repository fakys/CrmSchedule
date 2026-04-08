<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\Schedule;
use App\Modules\Crm\schedule\Entity\CorrectionSchedule;
use DateTime;

class ChangeScheduleEntity
{
    private $schedules = [];

    /**
     * @param CorrectionSchedule[] $CorrectionSchedules
     */
    public function __construct($CorrectionSchedules)
    {
        foreach ($CorrectionSchedules as $correctionSchedule) {
            /** @var Schedule $schedule */
            $schedule = $correctionSchedule->schedule()->first();
            $this->schedules[$schedule->student_group_id]
            [date('Y-m-d', strtotime($correctionSchedule->date_start))]
            [$schedule->getPairNumber()->number] = $schedule;
        }
    }


    public function getScheduleByData($studentGroupId, DateTime $date, $pairNumber)
    {
        return $this->schedules[$studentGroupId][$date->format('Y-m-d')][$pairNumber] ?? null;
    }
}
