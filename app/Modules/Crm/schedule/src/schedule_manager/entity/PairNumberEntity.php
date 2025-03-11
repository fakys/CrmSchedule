<?php
namespace App\Modules\Crm\schedule\src\entity;

class ScheduleUnit
{
    private $old_date;
    private $new_date;
    private $old_pair_number_id;
    private $new_pair_number_id;
    private $old_group_id;
    private $new_group_id;
    private $time_start;
    private $time_end;
    private $subject_id;
    private $user_id;
    private $format_pair_id;
    private $description;


    /** Дата до изменения в расписании */
    public function setOldDate($old_date)
    {
        $this->old_date = new \DateTime($old_date);
    }

    /**
     * @return \DateTime
     */
    public function getOldDate() {
        return $this->old_date;
    }

    /** Дата после изменения в расписании */
    public function setNewDate($new_date) {
        $this->new_date = new \DateTime($new_date);
    }

    /**
     * @return \DateTime
     */
    public function getNewDate() {
        return $this->new_date;
    }

    /** Номер пары до изменения в расписании */
    public function setOldPairNumber($old_pair_number_id){
        $this->old_pair_number_id = $old_pair_number_id;
    }
    public function getOldPairNumber(){
        return $this->old_pair_number_id;
    }

    /** Номер пары после изменения в расписании */
    public function setNewPairNumber($new_pair_number_id){
        $this->new_pair_number_id = $new_pair_number_id;
    }
    public function getNewPairNumber(){
        return $this->new_pair_number_id;
    }

    /** Номер группы до изменения в расписании */
    public function setOldGroup($old_group_id){
        $this->old_group_id = $old_group_id;
    }
    public function getOldGroup(){
        return $this->old_group_id;
    }

    /** Номер группы после изменения в расписании */
    public function setNewGroup($new_group_id){
        $this->new_group_id = $new_group_id;
    }
    public function getNewGroup(){
        return $this->new_group_id;
    }

    /** Новое время начала */
    public function setTimeStart($time_start){
        $this->time_start = $time_start;
    }
    public function getTimeStart(){
        return $this->time_start;
    }

    /** Новое время окончания */
    public function setTimeEnd($time_end){
        $this->time_end = $time_end;
    }
    public function getTimeEnd(){
        return $this->time_end;
    }

    /** Новый предмет */
    public function setSubject($subject_id){
        $this->subject_id = $subject_id;
    }
    public function getSubject(){
        return $this->subject_id;
    }

    /** Новый преподаватель */
    public function setUser($user_id){
        $this->user_id = $user_id;
    }
    public function getUser(){
        return $this->user_id;
    }

    /** Новый формат пары */
    public function setFormatPair($format_pair_id){
        $this->format_pair_id = $format_pair_id;
    }
    public function getFormatPair(){
        return $this->format_pair_id;
    }

    /** Новое описание */
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }

}
