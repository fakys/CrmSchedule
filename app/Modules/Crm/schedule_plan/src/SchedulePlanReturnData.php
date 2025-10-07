<?php

namespace App\Modules\Crm\schedule_plan\src;


use App\Entity\PlanSchedule;
use App\Src\BackendHelper;

class SchedulePlanReturnData
{
    private $semester_id;
    private $plan_type_id;
    private $card_name;

    private $pair_number;

    private $week_day;

    private $week_number;

    private $group_id;

    private $user_id;

    private $subject;

    private $time_start;

    private $time_end;

    private $description;

    private $format;

    public function __construct($card_name = null, $pair_number = null, $week_day = null, $week_number = null, $group_id = null, $user_id = null, $subject = null, $time_start = null, $time_end = null, $description = null, $semester_id = null, $plan_type_id = null, $format = null)
    {
        $this->card_name = $card_name;
        $this->pair_number = $pair_number;
        $this->week_day = $week_day;
        $this->week_number = $week_number;
        $this->group_id = $group_id;
        $this->user_id = $user_id;
        $this->subject = $subject;
        $this->time_start = $time_start;
        $this->time_end = $time_end;
        $this->description = $description;
        $this->semester_id = $semester_id;
        $this->plan_type_id = $plan_type_id;
        $this->format = $format;
    }

    public function getCardName()
    {
        return $this->card_name;
    }

    public function getPairNumber()
    {
        return $this->pair_number;
    }

    public function getWeekDay()
    {
        return $this->week_day;
    }

    public function getWeekNumber()
    {
        return $this->week_number;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getTimeStart()
    {
        return $this->time_start;
    }

    public function getTimeEnd()
    {
        return $this->time_end;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSemesterId()
    {
        return $this->semester_id;
    }

    public function getPlanTypeId()
    {
        return $this->plan_type_id;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function cardFormater($card_data)
    {
        $this->card_name = $card_data['cardName'];
        $this->pair_number = $card_data['numberPair'];
        $this->week_day = $card_data['weekDay'];
        $this->week_number = $card_data['weekNumber'];
        $this->group_id = $card_data['group'];
        $this->user_id = $card_data['user'];
        $this->subject = $card_data['subject'];
        $this->time_start = $card_data['time_start'];
        $this->time_end = $card_data['time_end'];
        $this->description = $card_data['description'];
        $this->semester_id = $card_data['semester'];
        $this->plan_type_id = $card_data['plan_type'];
        $this->format = $card_data['format'];
    }

    /**
     * @param PlanSchedule[] $plan
     * @return array
     */
    public static function cardCacheFormat($plan)
    {
        $schedule_data = ['schedule_data' => []];
        foreach ($plan as $key => $value) {
            $lesson = $value->getLesson();
            $pair_number = $value->getPairNumber();
            $plan_duration = $value->getDuration();
            $schedule_data['schedule_data'][] = [
                'cardName' => BackendHelper::getOperations()->cardName($lesson->user_id, $lesson->subject_id),
                'numberPair' => $pair_number->number,
                'weekDay' => $plan_duration->week_day,
                'weekNumber' => $plan_duration->week_number,
                'group' => $value->student_group_id,
                'user' => $lesson->user_id,
                'subject' => $lesson->subject_id,
                'time_start' => $plan_duration->time_start,
                'time_end' => $plan_duration->time_end,
                'description' => $value->description,
                'semester' => $value->semester_id,
                'plan_type' => $value->plan_type_id,
                'format' => $value->format_lesson_id,
            ];
        }

        return $schedule_data;
    }
}
