<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Modules\Crm\schedule\exceptions\HolidayException;
use App\Src\BackendHelper;
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
