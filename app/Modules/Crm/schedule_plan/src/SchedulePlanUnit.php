<?php
namespace App\Modules\Crm\schedule_plan\src;

class SchedulePlanUnit
{
    private $time_start;
    private $pair_id;
    private $time_end;
    private $subject_id;
    private $user_id;
    private $format_pair_id;
    private $description;
    private $semester_id;
    private $plan_type_id;
    private $week_number;
    private $week_day;

    /** время начала */
    public function setTimeStart($time_start){
        $this->time_start = $time_start;
    }
    public function getTimeStart(){
        return $this->time_start;
    }

    /** время окончания */
    public function setTimeEnd($time_end){
        $this->time_end = $time_end;
    }
    public function getTimeEnd(){
        return $this->time_end;
    }

    /** предмет */
    public function setSubject($subject_id){
        $this->subject_id = $subject_id;
    }
    public function getSubject(){
        return $this->subject_id;
    }

    /** преподаватель */
    public function setUser($user_id){
        $this->user_id = $user_id;
    }
    public function getUser(){
        return $this->user_id;
    }

    /** формат пары */
    public function setFormatPair($format_pair_id){
        $this->format_pair_id = $format_pair_id;
    }
    public function getFormatPair(){
        return $this->format_pair_id;
    }

    /** описание */
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }

    public function getSemesterId()
    {
        return $this->semester_id;
    }

    public function setSemesterId($semester_id){
        $this->semester_id = $semester_id;
    }

    public function getPlanTypeId(){
        return $this->plan_type_id;
    }

    public function setPlanTypeId($plan_type_id){
        $this->plan_type_id = $plan_type_id;
    }

    public function getWeekNumber() {
        return $this->week_number;
    }

    public function setWeekNumber($week_number) {
        $this->week_number = $week_number;
    }

    public function getWeekDay() {
        return $this->week_day;
    }

    public function setWeekDay($week_day) {
        $this->week_day = $week_day;
    }

    public function getPairId()
    {
        return $this->pair_id;
    }

    public function setPairId($pair_id){
        $this->pair_id = $pair_id;
    }
}
