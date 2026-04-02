<?php

namespace App\Modules\Crm\schedule_plan\src\schedule_parse;

class ScheduleParseReturnData
{
    //День недели
    private $week_day;

    //Номер недели
    private $week_number;

    //Номер пары
    private $pair_number;

    //Группа
    private $group_id;

    //Предмет
    private $subject_id;

    //Преподаватель
    private $teacher_id;

    public function __construct($week_day, $week_number, $pair_number, $group_id, $subject_id, $teacher_id)
    {
        $this->week_day = $week_day;
        $this->week_number = $week_number;
        $this->pair_number = $pair_number;
        $this->group_id = $group_id;
        $this->subject_id = $subject_id;
        $this->teacher_id = $teacher_id;
    }

    public function getWeekDay()
    {
        return $this->week_day;
    }

    public function getWeekNumber()
    {
        return $this->week_number;
    }

    public function getPairNumber()
    {
        return $this->pair_number;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function getSubjectId()
    {
        return $this->subject_id;
    }

    public function getTeacherId()
    {
        return $this->teacher_id;
    }
}
