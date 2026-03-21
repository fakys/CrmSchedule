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
            [$item->student_group_id][$item->getDuration()->week_number][$item->getDuration()->week_day][] = $planSchedule;
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
    public function getPlanScheduleByData($group_id, $semester, $pair_number, $week_day, $current_day)
    {
        foreach ($this->planSchedule as $planSchedule) {
            if (
                $planSchedule->group_id == $group_id &&
                $planSchedule->semester_id == $semester['id'] &&
                $planSchedule->pair_number == $pair_number &&
                $planSchedule->week_day == $week_day
            ) {
                $params = json_decode($planSchedule->type_prams, 1);
                if (isset($params['weeks'])) {
                    $week_count = count($params['weeks']);
                    if (
                        $planSchedule->week_number == BackendHelper::getOperations()->getCurrentWeek($current_day, new \DateTime($semester['date_start']), $week_count)
                    ) {
                        return $planSchedule;
                    }
                }else {
                    return $planSchedule;
                }

            }
        }
    }


    public function getSchedule()
    {
        return $this->planSchedule;
    }
}
