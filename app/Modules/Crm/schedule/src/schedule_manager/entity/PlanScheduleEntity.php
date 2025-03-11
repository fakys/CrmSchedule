<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;
use GuzzleHttp\Test\StrClass;

/** Сущность для плана пар из репозитория */
class PlanScheduleEntity
{
    /**
     * @var StrClass[]
     */
    private $planSchedule;

    /**
     * @param array $planSchedule
     */
    public function __construct($planSchedule)
    {
        $this->planSchedule = $planSchedule;
    }

    /**
     * Возвращает план расписания по данным
     * @param $group_id
     * @param $semester
     * @param $pair_number
     * @param $week_day
     * @return array
     */
    public function getPlanScheduleByData($group_id, $semester_id, $pair_number, $week_day)
    {
        foreach ($this->planSchedule as $planSchedule) {
            if (
                $planSchedule->group_id == $group_id &&
                $planSchedule->semester_id == $semester_id &&
                $planSchedule->pair_number == $pair_number &&
                $planSchedule->week_day == $week_day
            ) {
                return $planSchedule;
            }
        }
    }


    public function getSchedule()
    {
        return $this->planSchedule;
    }
}
