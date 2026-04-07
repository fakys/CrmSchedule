<?php
namespace App\Modules\Crm\schedule_plan\src;


/** Сущность расписания в кеше */
class SchedulePlanReturnData
{
    private $semester_id;
    private $groups_id;
    private $specialties_id;
    private $plan_type;
    private $schedule_data;

    private $error_message = '';

    public function __construct($semester_id, $groups_id, $specialties_id, $plan_type, $schedule_data, $error_message = '')
    {
        $this->semester_id = $semester_id;
        $this->groups_id = $groups_id;
        $this->specialties_id = $specialties_id;
        $this->plan_type = $plan_type;
        $this->schedule_data = $schedule_data;
        $this->error_message = $error_message;
    }

    public function getSemesterId()
    {
        return $this->semester_id;
    }

    public function setSemesterId($semester_id)
    {
        $this->semester_id = $semester_id;
    }

    public function getGroupsId()
    {
        return $this->groups_id;
    }

    public function setGroupsId($groups_id)
    {
        $this->groups_id = $groups_id;
    }

    public function getSpecialtiesId()
    {
        return $this->specialties_id;
    }

    public function setSpecialtiesId($specialties_id)
    {
        $this->specialties_id = $specialties_id;
    }

    public function getPlanType()
    {
        return $this->plan_type;
    }

    public function setPlanType($plan_type)
    {
        $this->plan_type = $plan_type;
    }

    public function getScheduleData()
    {
        return $this->schedule_data;
    }

    public function setScheduleData($schedule_data)
    {
        $this->schedule_data = $schedule_data;
    }

    public function getErrorMessage()
    {
        return $this->error_message;
    }

    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    public function toArray(): array
    {
        return [
            'semester' => $this->semester_id,
            'groups' => $this->groups_id,
            'specialties' => $this->specialties_id,
            'plan_type' => $this->plan_type,
            'schedule_data' => $this->schedule_data,
            'error_message' => $this->error_message,
        ];
    }
}
