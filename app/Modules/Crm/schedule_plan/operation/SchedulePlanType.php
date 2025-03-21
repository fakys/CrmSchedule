<?php
namespace App\Modules\Crm\schedule_plan\operation;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class SchedulePlanType extends Operation{

    /**
     * Добавляет тип плана расписания
     * @param array $data
     * @return true
     */
    public function addSchedulePlanType($data)
    {
        $name = $data['name'];
        $json_data = json_encode($data['data']);
        BackendHelper::getRepositories()->addSchedulePlanType($name, $json_data);
        return true;
    }

    /**
     * Форматирует дни недели
     * @return array
     */
    public function formatWeeks($weeks)
    {
        foreach ($weeks as $number => $week) {
            $week['week_end'][7] = $week['week_end'][0];
            unset($week['week_end'][0]);
            $weeks[$number] = $week;
        }
        return $weeks;
    }

}
