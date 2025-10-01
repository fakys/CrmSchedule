<?php

namespace App\Modules\Crm\schedule_plan\src;


class SchedulePlanReturnData
{
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

    public function __construct($card_name = null, $pair_number = null, $week_day = null, $week_number = null, $group_id = null, $user_id = null, $subject = null, $time_start = null, $time_end = null, $description = null)
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

    public function cardFormater($card_data)
    {
        $this->card_name = $card_data['cardName'];
        $this->pair_number = $card_data['pairNumber'];
        $this->week_day = $card_data['weekDay'];
        $this->week_number = $card_data['weekNumber'];
        $this->group_id = $card_data['group'];
        $this->user_id = $card_data['user'];
        $this->subject = $card_data['subject'];
        $this->time_start = $card_data['time_start'];
        $this->time_end = $card_data['time_end'];
        $this->description = $card_data['description'];
    }
}
