<?php

namespace App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule;

use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\BackendHelper;

class ScheduleManagerReturnData
{
    /**
     * @var Schedule $schedule
     */
    private $schedule;


    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getSchedule()
    {
        $schedule_return_data = [];

        foreach ($this->schedule->getScheduleUnits() as $unit) {
            $schedule_return_data[$unit->getSemester()]['semester_data']
            [$unit->getGroup()]['group_data']
            [$unit->getDate()->format('d.m.Y')]
            [$unit->getPairNumber()] = $unit;

            $schedule_return_data[$unit->getSemester()]['semester_name'] =
                BackendHelper::getRepositories()->getSemesterById($unit->getSemester())->name;

            $schedule_return_data[$unit->getSemester()]['semester_data'][$unit->getGroup()]['group_number'] =
                BackendHelper::getRepositories()->getStudentGroupById($unit->getGroup())->number;
        }

        return $schedule_return_data;
    }

}
