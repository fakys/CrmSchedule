<?php

namespace App\Modules\Crm\schedule\src\schedule_manager;

use App\Modules\Crm\schedule\src\schedule_manager\entity\HolidayEntity;
use App\Src\BackendHelper;

class ScheduleUnit
{
    private $date;
    private $pair_number;
    private $group_id;
    private $week_number;
    private $week_day;
    private $time_start;
    private $time_end;
    private $subject_id;
    private $user_id;
    private $format_pair_id;
    private $description;
    private $semester;
    private $is_base_schedule;
    private $semester_name;

    /** @var bool $weekday */
    private $week_end = false;
    /** @var HolidayEntity $holiday */
    private $holiday;


    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function setPairNumber($pair_number)
    {
        $this->pair_number = $pair_number;
    }

    /**
     * Возвращает НОМЕР пары
     * @return int
     */
    public function getPairNumber()
    {
        return $this->pair_number;
    }

    public function setGroup($group_id)
    {
        $this->group_id = $group_id;
    }

    public function getGroup()
    {
        return $this->group_id;
    }

    public function setTimeStart($time_start)
    {
        $this->time_start = $time_start ? new \DateTime($time_start) : null;
    }

    public function getTimeStart()
    {
        return $this->time_start;
    }

    public function setTimeEnd($time_end)
    {
        $this->time_end = $time_end ? new \DateTime($time_end) : null;
    }

    public function getTimeEnd()
    {
        return $this->time_end;
    }

    public function setSubject($subject_id)
    {
        $this->subject_id = $subject_id;
    }

    public function getSubject()
    {
        return $this->subject_id;
    }

    public function getSubjectName()
    {
        if ($this->subject_id) {
            return BackendHelper::getRepositories()->getSubjectById($this->subject_id)->name;
        }
    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function getUserFio()
    {
        if ($this->user_id) {
            $user = BackendHelper::getRepositories()->getUserById($this->user_id)->getInfo();
            return sprintf('%s %s %s', $user->first_name, $user->last_name, $user->email);
        }

    }

    public function setFormatPair($format_pair_id)
    {
        $this->format_pair_id = $format_pair_id;
    }

    public function getFormatPair()
    {
        return $this->format_pair_id;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSemester()
    {
        return $this->semester;
    }

    public function setSemester($semester_id)
    {
        $this->semester = $semester_id;
    }

    public function setSemesterName($semester_name)
    {
        $this->semester_name = $semester_name;
    }

    public function getSemesterName()
    {
        return $this->semester_name;
    }

    public function getWeekEnd()
    {
        return $this->week_end;
    }

    public function setWeekEnd($week_end)
    {
        $this->week_end = $week_end;
    }

    public function isBaseSchedule()
    {
        return $this->is_base_schedule;
    }

    public function setBaseSchedule($is_base_schedule)
    {
        $this->is_base_schedule = $is_base_schedule;
    }

    public function getWeekNumber()
    {
        return $this->week_number;
    }

    public function setWeekNumber($week_number)
    {
        $this->week_number = $week_number;
    }

    public function setWeekDay($week_day)
    {
        $this->week_day = $week_day;
    }

    public function getWeekDay()
    {
        return $this->week_day;
    }

    /**
     * @param HolidayEntity|null $holiday
     * @return void
     */
    public function setHoliday($holiday)
    {
        $this->holiday = $holiday;
    }

    /**
     * @return HolidayEntity
     */
    public function getHoliday()
    {
        return $this->holiday;
    }

    /**
     * Проверяет пустой ли юнит
     * @return bool
     */
    public function isEmpty()
    {
        if (
            $this->format_pair_id
            && $this->semester
            && $this->user_id
            && $this->group_id
            && $this->subject_id
            && $this->time_end
            && $this->time_start
        ) {
            return false;
        }

        return true;
    }
}
