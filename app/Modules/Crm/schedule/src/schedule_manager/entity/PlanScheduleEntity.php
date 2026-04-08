<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PlanSchedule;
use App\Entity\Schedule;
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
            /** @var Schedule $schedule */
            $schedule = $item->schedule()->first();
            $this->planSchedule[$item->semester_id]
            [$schedule->student_group_id][$item->week_number][$item->week_day][$schedule->getPairNumber()->number] = $item;
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
