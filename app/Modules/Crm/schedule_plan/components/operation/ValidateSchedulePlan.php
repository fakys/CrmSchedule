<?php

namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Src\modules\operations\AbstractOperation;

class ValidateSchedulePlan extends AbstractOperation
{
    public function getName(): string
    {
        return 'validate_schedule_plan_operation';
    }

    /**
     * @param CardEntity $card_data
     * @param CardEntity[] $all_schedule_data
     * @return array
     * @throws \DateMalformedStringException
     */
    public function validateCard(CardEntity $card_data, $all_schedule_data)
    {
        $errors = [];
        if (!$card_data->getTimeStart()) {
            $errors[] = ['timeStart' => 'Обязательное поле'];
        }
        if (!$card_data->getTimeEnd()) {
            $errors[] = ['timeEnd' => 'Обязательное поле'];
        }
        if (!$card_data->getTeacherId()) {
            $errors[] = ['teacherId' => 'Обязательное поле'];
        }
        if (!$card_data->getSubjectId()) {
            $errors[] = ['subjectId' => 'Обязательное поле'];
        }
        if (!$card_data->getFormatId()) {
            $errors[] = ['formatId' => 'Обязательное поле'];
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
                        !(
                            ($time_start > $valid_time_end && $time_end > $valid_time_start) ||
                            ($valid_time_end > $time_start && $time_end < $valid_time_start)
                        )
                    ) {
                        $errors[] = ['teacherId' => 'Этот преподаватель пересекается с '.$schedule_data->getCardName()];
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


        return $errors;
    }

}
