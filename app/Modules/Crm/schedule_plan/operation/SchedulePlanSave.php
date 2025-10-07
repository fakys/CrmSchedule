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
        if (
            isset($card_data['cardName']) &&
            isset($card_data['numberPair']) &&
            isset($card_data['weekDay']) &&
            isset($card_data['weekNumber']) &&
            isset($card_data['group']) &&
            isset($card_data['user']) &&
            isset($card_data['subject']) &&
            isset($card_data['time_start']) &&
            isset($card_data['time_end']) &&
            isset($card_data['format'])
        ) {
            $schedule_obj = new SchedulePlanReturnData();
            $schedule_obj->cardFormater($card_data);

            if (isset($schedule_obj)) {
                $lesson = BackendHelper::getRepositories()->getLessonByTeacherAndSubject($schedule_obj->getUserId(), $schedule_obj->getSubject());

                if (!$lesson) {
                    throw new SchedulePlanAddException('связь предмета и преподавателя не была найдена');
                }
                $pair_number = BackendHelper::getRepositories()->getPairByNumber($schedule_obj->getPairNumber());

                if (!$pair_number) {
                    throw new SchedulePlanAddException('Не найдена пара');
                }

                $duration = BackendHelper::getRepositories()->addPlanDurationLessons(
                    $schedule_obj->getWeekDay(),
                    $schedule_obj->getTimeStart(),
                    $schedule_obj->getTimeEnd(),
                    $schedule_obj->getWeekNumber()
                );

                if (empty($duration)) {
                    throw new SchedulePlanAddException('Ошибка создания длительности пары');
                }

                BackendHelper::getRepositories()->addSchedulePlan(
                    $duration->id,
                    $pair_number->id,
                    $schedule_obj->getGroupId(),
                    $schedule_obj->getSemesterId(),
                    $schedule_obj->getPlanTypeId(),
                    $lesson->id,
                    $schedule_obj->getFormat(),
                    $schedule_obj->getDescription(),
                );
            }
        }
    }

    public function getName(): string
    {
        return 'schedule_plan_save_operation';
    }
}
