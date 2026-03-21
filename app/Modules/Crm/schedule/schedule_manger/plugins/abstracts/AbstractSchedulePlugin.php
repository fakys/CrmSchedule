<?php

namespace App\Modules\Crm\schedule\schedule_manger\plugins\abstracts;


use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Modules\Crm\schedule_plan\src\SchedulePlanEntity;
use App\Src\modules\plugins\AbstractPlugin;
use DateTime;

abstract class AbstractSchedulePlugin extends AbstractPlugin
{
    private ScheduleSearchData $searchData;
    private SemesterEntity $semesters;

    private Schedule $schedule;
    private PairNumberEntity $pair_numbers;

    private PlanScheduleEntity $schedule_plan;

    abstract public function Execute();

    /**
     * Добавляет расписание
     * @param \DateTime $date
     */
    public function addUnit(
        DateTime $date,
                 $pair_number,
                 $group_id,
                 $semester_id,
                 $schedule_week_number,
                 $schedule_week_day,

                 $schedule_time_start = null,
                 $schedule_time_end = null,
                 $subject_id = null,
                 $teacher_id = null,
                 $format_lesson_id = null,
                 $schedule_description = null,
    ): ScheduleUnit
    {
        $schedule_unit = new ScheduleUnit();
        $schedule_unit->setDate($date);
        $schedule_unit->setPairNumber($pair_number);
        $schedule_unit->setGroup($group_id);
        $schedule_unit->setTimeStart($schedule_time_start);
        $schedule_unit->setTimeEnd($schedule_time_end);
        $schedule_unit->setSubject($subject_id);
        $schedule_unit->setUser($teacher_id);
        $schedule_unit->setFormatPair($format_lesson_id);
        $schedule_unit->setDescription($schedule_description);
        $schedule_unit->setSemester($semester_id);
        $schedule_unit->setWeekNumber($schedule_week_number);
        $schedule_unit->setWeekDay($schedule_week_day);

        $this->schedule->addUnit($schedule_unit);

        return $schedule_unit;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    public function getSemesters()
    {
        return $this->semesters;
    }

    public function getPairNumbers()
    {
        return $this->pair_numbers;
    }

    public function getSearchData()
    {
        return $this->searchData;
    }

    public function setSchedule(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function setSemester(SemesterEntity $semester)
    {
        $this->semesters = $semester;
    }

    public function setPairNumbers(PairNumberEntity $pair_numbers)
    {
        $this->pair_numbers = $pair_numbers;
    }

    public function setSearchData(ScheduleSearchData $searchData)
    {
        $this->searchData = $searchData;
    }

    public function getSchedulePlan(): PlanScheduleEntity
    {
        return $this->schedule_plan;
    }

    public function setSchedulePlan(PlanScheduleEntity $schedule_plan)
    {
        $this->schedule_plan = $schedule_plan;
    }

    abstract public function index();
}
