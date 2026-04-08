<?php

namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Entity\Lesson;
use App\Entity\Schedule;
use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class ValidateSchedulePlan extends AbstractOperation
{
    public function getName(): string
    {
        return 'validate_schedule_plan_operation';
    }

    public function validateCardThroughDataBaseInfo(CardEntity $card_data, $all_groups)
    {
         $schedules_plan = BackendHelper::getRepositories()->getPlanScheduleByDayAndException(
             $card_data->getTeacherId(),
             $card_data->getWeekDay(),
             $card_data->getWeekNumber(),
             $card_data->getSemesterId(),
             $card_data->getNumberPair(),
             $all_groups
         );

         if ($schedules_plan) {
             /** @var Schedule $schedule */
             $schedule = $schedules_plan->schedule()->first();
             /** @var StudentGroup $group */
             $group = $schedule->group()->first();
             /** @var Lesson $lesson */
             $lesson = $schedule->lesson()->first();

             $errors = [
                 ['teacherId' => 'Этот преподаватель пересекается с '.BackendHelper::getOperations()->cardName($lesson->user_id, $lesson->subject_id).' Группа: '.$group->number]
             ];
             return $errors;
         }
         return [];
    }

    /**
     * метод проверки карты
     * @param CardEntity $card_data
     * @param CardEntity[] $all_schedule_data
     * @param array $all_groups
     * @return array
     * @throws \DateMalformedStringException
     */
    public function validateCard(CardEntity $card_data, $all_schedule_data, $all_groups)
    {
        $errors = [];
        if (!$card_data->getTimeStart()) {
            $errors[] = ['timeStart' => 'Обязательное поле "Время начала"'];
        }
        if (!$card_data->getTimeEnd()) {
            $errors[] = ['timeEnd' => 'Обязательное поле "Время окончание"'];
        }
        if (!$card_data->getTeacherId()) {
            $errors[] = ['teacherId' => 'Обязательное поле "Преподаватель"'];
        }
        if (!$card_data->getSubjectId()) {
            $errors[] = ['subjectId' => 'Обязательное поле "Предмет"'];
        }
        if (!$card_data->getFormatId()) {
            $errors[] = ['formatId' => 'Обязательное поле "Формат пары"'];
        }

        if ($errors) {
            return $errors;
        }

        $time_start = new \DateTime(date('Y-m-d').' '.$card_data->getTimeStart());
        $time_end = new \DateTime(date('Y-m-d').' '.$card_data->getTimeEnd());
        if ($time_start->getTimestamp() > $time_end->getTimestamp()) {
            $errors[] = ['timeStart' => 'Время начала больше чем время окончания'];
            return $errors;
        }

        if ($all_schedule_data) {
            foreach ($all_schedule_data as $schedule_data) {
                if ($schedule_data->getTimeStart() && $schedule_data->getTimeEnd()) {
                    $valid_time_start = new \DateTime(date('Y-m-d').' '.$schedule_data->getTimeStart());
                    $valid_time_end = new \DateTime(date('Y-m-d').' '.$schedule_data->getTimeEnd());
                    if (
                        $schedule_data->getTeacherId() == $card_data->getTeacherId() &&
                        $schedule_data->getWeekNumber() == $card_data->getWeekNumber() &&
                        $schedule_data->getWeekDay() == $card_data->getWeekDay() &&
                        !(
                            ($time_start > $valid_time_end && $time_end > $valid_time_start) ||
                            ($valid_time_end > $time_start && $time_end < $valid_time_start)
                        )
                    ) {
                        $group = BackendHelper::getRepositories()->getStudentGroupById($schedule_data->getGroupId());
                        $errors[] = ['teacherId' => 'Этот преподаватель пересекается с '.$schedule_data->getCardName().' Группа: '.$group->name];
                        break;
                    } elseif (
                        $schedule_data->getWeekNumber() == $card_data->getWeekNumber() &&
                        $schedule_data->getWeekDay() == $card_data->getWeekDay() &&
                        $schedule_data->getGroupId() == $card_data->getGroupId() &&
                        !(
                            ($time_start > $valid_time_end && $time_end > $valid_time_start) ||
                            ($valid_time_end > $time_start && $time_end < $valid_time_start)
                        )
                    ) {
                        $errors[] = ['timeStart' => 'В это время группа занята '.$schedule_data->getCardName()];
                        break;
                    }
                }
            }
        }

        $errorsDB = BackendHelper::getOperations()->validateCardThroughDataBaseInfo(
            $card_data,
            $all_groups
        );
        if ($errorsDB) {
            $errors = array_merge($errors, $errorsDB);
        }

        return $errors;
    }

}
