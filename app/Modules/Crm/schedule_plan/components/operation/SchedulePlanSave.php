<?php
namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class SchedulePlanSave extends AbstractOperation
{

    /**
     * @param CardEntity $card_data
     * @return void
     */
    public function saveSchedulePlan($card_data)
    {
        if (
            $card_data->getTeacherId() &&
            $card_data->getSubjectId() &&
            $card_data->getTimeStart() &&
            $card_data->getTimeEnd()
        ) {
            $lesson = BackendHelper::getRepositories()->getLessonByTeacherAndSubject($card_data->getTeacherId(), $card_data->getSubjectId());

            if (!$lesson) {
                throw new SchedulePlanAddException('связь предмета и преподавателя не была найдена');
            }
            $pair_number = BackendHelper::getRepositories()->getPairByNumber($card_data->getNumberPair());

            if (!$pair_number) {
                throw new SchedulePlanAddException('Не найдена пара');
            }

            /** todo Сделать длительность в минутах */
            $duration = BackendHelper::getRepositories()->createDurationLessons(
                $card_data->getTimeStart(),
                $card_data->getTimeEnd()
            );

            if (empty($duration)) {
                throw new SchedulePlanAddException('Ошибка создания длительности пары');
            }

            $schedule = BackendHelper::getRepositories()->addSchedule(
                $duration->id,
                $pair_number->id,
                $card_data->getDescription(),
                $card_data->getGroupId(),
                $lesson->id,
                $card_data->getFormatId(),
            );

            BackendHelper::getRepositories()->addSchedulePlan(
                $schedule->id,
                $card_data->getSemesterId(),
                $card_data->getPlanTypeId(),
                $card_data->getWeekDay(),
                $card_data->getWeekNumber()
            );
        }
    }

    public function getName(): string
    {
        return 'schedule_plan_save_operation';
    }
}
