<?php
namespace App\Modules\Crm\schedule\operations;

use App\Modules\Crm\schedule\src\ScheduleManager;
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
        $period = BackendHelper::getOperations()->pacePeriod($data['period']);
        $groups = isset($data['groups']) ? $data['groups'] : [];
        $specialties = isset($data['specialties']) ? $data['specialties'] : [];
        $manager = new ScheduleManager($period, $groups, $specialties);
        return $manager->getSchedule();
    }
}
