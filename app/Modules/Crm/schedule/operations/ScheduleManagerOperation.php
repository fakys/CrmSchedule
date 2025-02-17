<?php
namespace App\Modules\Crm\schedule\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class ScheduleManagerOperation extends Operation
{
    /**
     * Возвращает расписание для менеджера расписаний
     * @return array
     */
    public function getScheduleData($data)
    {
        $period = $data['period'];
        $groups = isset($data['groups']) ? $data['groups'] : [];
        $specialties = isset($data['specialties']) ? $data['specialties'] : [];
        $main_data = [];

        if ($groups) {
            foreach ($groups as $group) {
                $data_rep = BackendHelper::getRepositories()->getScheduleByGroupFroManager($period, $group);
                $schedule = [];
                foreach ($data_rep as $schedule) {
                    $schedule[] = $schedule;
                }
                $main_data[$group] = [

                ];
            }

        } elseif ($specialties) {

        }

        return [];
    }
}
