<?php
namespace App\Modules\Crm\schedule\src\schedule_manager;

class ScheduleUnit
{
    private $date;
    private $pair_number;
    private $group_id;
    private $time_start;
    private $time_end;
    private $subject_id;
    private $user_id;
    private $format_pair_id;
    private $description;
    private $semester;

    /** @var bool $weekday */
    private $weekday = false;


    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    public function setPairNumber($pair_number_id){
        $this->pair_number = $pair_number_id;
    }
    public function getPairNumber(){
        return $this->pair_number;
    }

    public function setGroup($group_id){
        $this->group_id = $group_id;
    }
    public function getGroup(){
        return $this->group_id;
    }

    public function setTimeStart($time_start){
        $this->time_start = $time_start;
    }
    public function getTimeStart(){
        return $this->time_start;
    }

    public function setTimeEnd($time_end){
        $this->time_end = $time_end;
    }
    public function getTimeEnd(){
        return $this->time_end;
    }

    public function setSubject($subject_id){
        $this->subject_id = $subject_id;
    }
    public function getSubject(){
        return $this->subject_id;
    }

    public function setUser($user_id){
        $this->user_id = $user_id;
    }
    public function getUser(){
        return $this->user_id;
    }

    public function setFormatPair($format_pair_id){
        $this->format_pair_id = $format_pair_id;
    }
    public function getFormatPair(){
        return $this->format_pair_id;
    }

    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
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

    public function getWeekday()
    {
        return $this->weekday;
    }

    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;
    }

}
