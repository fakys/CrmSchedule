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
            [$unit->getDate()->format('d.m.Y')]['pair_units']
            [$unit->getPairNumber()] = $unit;

            $schedule_return_data[$unit->getSemester()]['semester_name'] =
                BackendHelper::getRepositories()->getSemesterById($unit->getSemester())->name;

            $schedule_return_data[$unit->getSemester()]['semester_data'][$unit->getGroup()]['group_number'] =
                BackendHelper::getRepositories()->getStudentGroupById($unit->getGroup())->number;

            $schedule_return_data[$unit->getSemester()]['semester_data']
            [$unit->getGroup()]['group_data'][$unit->getDate()->format('d.m.Y')]['is_weekday'] = $unit->getWeekEnd();

            $schedule_return_data[$unit->getSemester()]['semester_data']
            [$unit->getGroup()]['group_data'][$unit->getDate()->format('d.m.Y')]['holiday'] = $unit->getHoliday();
        }

        return $schedule_return_data;
    }

}
