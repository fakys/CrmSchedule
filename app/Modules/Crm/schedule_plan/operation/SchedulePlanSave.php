<?php
namespace App\Modules\Crm\schedule_plan\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use App\Src\redis\RedisManager;

class SchedulePlanSave extends AbstractOperation
{

    /**
     * @param array $card_data
     * @return void
     */
    public function saveSchedulePlan($card_data)
    {
        $schedule = [];
        foreach ($card_data as $data) {
            $schedule_obj = new SchedulePlanReturnData();
            $schedule_obj->cardFormater($data);
            $schedule[] = $schedule_obj;
        }


        foreach ($schedule as $schedule_obj) {
            $duration = BackendHelper::getRepositories()->addPlanDurationLessons(
                $schedule_obj->getWeekDay(),
                $schedule_obj->getTimeStart(),
                $schedule_obj->getTimeEnd(),
                $schedule_obj->getWeekNumber()
            );

            if (!$duration) {
                throw new SchedulePlanAddException('Ошибка создания длительности пары');
            }
        }
    }

    public function getName(): string
    {
        return 'schedule_plan_save_operation';
    }
}
