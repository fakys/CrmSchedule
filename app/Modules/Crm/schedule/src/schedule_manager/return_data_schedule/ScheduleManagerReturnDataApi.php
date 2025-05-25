<?php

namespace App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule;

use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Src\BackendHelper;

class ScheduleManagerReturnDataApi
{
    /**
     * @var Schedule|ScheduleUnit[] $schedule
     */
    private $schedule;


    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    public function getSchedule()
    {
        $schedule_return_data = [];

        foreach (is_object($this->schedule)?$this->schedule->getScheduleUnits():$this->schedule as $key=>$unit) {
            if (isset($schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()])) {
                continue;
            }
            if (!$unit->isEmpty()) {
                $schedule_return_data[$unit->getSemester()]['semester_name'] = $unit->getSemesterName();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['date'] = $unit->getDate()->format('d.m.Y');
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['pair_number'] = $unit->getPairNumber();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['time_start'] = $unit->getTimeStart()->format('H:i');
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['time_end'] = $unit->getTimeEnd()->format('H:i');
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['teacher_fio'] = $unit->getUserFio();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['subject_name'] = $unit->getSubjectName();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['week_day'] = $unit->getWeekDay();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['is_empty'] = $unit->isEmpty();
            } else {
                $schedule_return_data[$unit->getSemester()]['semester_name'] = $unit->getSemesterName();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['date'] = $unit->getDate()->format('d.m.Y');
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['pair_number'] = $unit->getPairNumber();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['week_day'] = $unit->getWeekDay();
                $schedule_return_data[$unit->getSemester()]['schedule'][$unit->getWeekDay()][$unit->getPairNumber()]['is_empty'] = $unit->isEmpty();
            }
        }

        return $schedule_return_data;
    }

}
