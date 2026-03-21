<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PlanSchedule;
use App\Src\BackendHelper;

/** Сущность для плана пар из репозитория */
class PlanScheduleEntity
{
    private array $planSchedule;

    /**
     * @param PlanSchedule[] $planSchedule
     */
    public function __construct($planSchedule)
    {
        foreach ($planSchedule as $item) {
            $this->planSchedule[$item->semester_id]
            [$item->student_group_id][$item->getDuration()->week_number][$item->getDuration()->week_day][$item->getPairNumber()->number] = $item;
        }

    }

    public function getPlanScheduleBySemesterAndGroup($semester_id, $group_id): array
    {
        return $this->planSchedule[$semester_id][$group_id] ?? [];
    }

    /**
     * Возвращает план расписания по данным
     * @param $group_id
     * @param $semester
     * @param $pair_number
     * @param $week_day
     * @return array
     */
    public function getPlanScheduleByData($semester_id, $group_id, $week_number, $week_day, $pair_number)
    {
        return $this->planSchedule[$semester_id][$group_id][$week_number][$week_day][$pair_number] ?? null;
    }


    public function getSchedule()
    {
        return $this->planSchedule;
    }
}
