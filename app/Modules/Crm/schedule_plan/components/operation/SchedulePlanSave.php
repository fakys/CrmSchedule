<?php
namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class SchedulePlanSave extends AbstractOperation
{

    /**
     * todo сделать через DTO
     * @param array $card_data
     * @return void
     */
    public function saveSchedulePlan($card_data)
    {
        if (
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

            $lesson = BackendHelper::getRepositories()->getLessonByTeacherAndSubject($schedule_obj->getUserId(), $schedule_obj->getSubject());

            if (!$lesson) {
                throw new SchedulePlanAddException('связь предмета и преподавателя не была найдена');
            }
            $pair_number = BackendHelper::getRepositories()->getPairByNumber($schedule_obj->getPairNumber());

            if (!$pair_number) {
                throw new SchedulePlanAddException('Не найдена пара');
            }

            /** todo Сделать длительность в минутах */
            $duration = BackendHelper::getRepositories()->createDurationLessons(
                $schedule_obj->getTimeStart(),
                $schedule_obj->getTimeEnd()
            );

            if (empty($duration)) {
                throw new SchedulePlanAddException('Ошибка создания длительности пары');
            }

            $schedule = BackendHelper::getRepositories()->addSchedule(
                $duration->id,
                $pair_number->id,
                $schedule_obj->getDescription(),
                $schedule_obj->getGroupId(),
                $lesson->id,
                $schedule_obj->getFormat(),
            );

            BackendHelper::getRepositories()->addSchedulePlan(
                $schedule->id,
                $schedule_obj->getSemesterId(),
                $schedule_obj->getPlanTypeId(),
                $schedule_obj->getWeekDay(),
                $schedule_obj->getWeekNumber()
            );
        }
    }

    public function getName(): string
    {
        return 'schedule_plan_save_operation';
    }
}
