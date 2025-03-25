<?php

namespace App\Modules\Crm\schedule\src\schedule_manager\entity\units;


class SemesterUnit
{
    private $semester_id;
    private $date_start;
    private $date_end;
    private $name;
    private $year_start;
    private $year_end;
    private $group_id;
    private $type_plan_id;
    private $type_plan_param;

    public function __construct($semester_id, $date_start, $date_end, $name, $year_start, $year_end, $group_id, $type_plan_id = null, $type_plan_param = null)
    {
        $this->semester_id = $semester_id;
        $this->date_start = new \DateTime($date_start);
        $this->date_end = new \DateTime($date_end);
        $this->name = $name;
        $this->year_start = $year_start;
        $this->year_end = $year_end;
        $this->group_id = $group_id;
        $this->type_plan_id = $type_plan_id;
        $this->type_plan_param = $type_plan_param;
    }

    public function getSemesterId()
    {
        return $this->semester_id;
    }

    public function setSemesterId($semester_id)
    {
        $this->semester_id = $semester_id;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param \DateTime $date_start
     * @return void
     */
    public function setDateStart($date_start){
        $this->date_start = $date_start;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(){
        return $this->date_end;
    }

    /**
     * @param \DateTime $date_end
     * @return void
     */
    public function setDateEnd($date_end){
        $this->date_end = $date_end;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getYearStart(){
        return $this->year_start;
    }


    public function setYearStart($year_start){
        $this->year_start = $year_start;
    }


    public function getYearEnd(){
        return $this->year_end;
    }


    public function setYearEnd($year_end){
        $this->year_end = $year_end;
    }

    public function getGroupId(){
        return $this->group_id;
    }

    public function setGroupId($group_id){
        $this->group_id = $group_id;
    }

    public function getTypePlanId()
    {
        return $this->type_plan_id;
    }

    public function setTypePlanId($type_plan_id){
        $this->type_plan_id = $type_plan_id;
    }

    public function getTypePlanParam(){
        return $this->type_plan_param;
    }

    public function setTypePlanParam($type_plan_param){
        $this->type_plan_param = $type_plan_param;
    }
}
