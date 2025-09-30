<?php

namespace App\Modules\Crm\schedule_plan\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use App\Src\redis\RedisManager;

class ValidateSchedulePlan extends AbstractOperation
{
    public function getName(): string
    {
        return 'validate_schedule_plan_operation';
    }

    public function validateCard($card_data, $all_schedule_data)
    {
        $errors = [];

        if (empty($card_data['time_start'])) {
            $errors[] = ['time_start' => 'Обязательное поле'];
        }
        if (empty($card_data['time_end'])) {
            $errors[] = ['time_end' => 'Обязательное поле'];
        }
        if (empty($card_data['user'])) {
            $errors[] = ['user' => 'Обязательное поле'];
        }
        if (empty($card_data['subject'])) {
            $errors[] = ['subject' => 'Обязательное поле'];
        }

        if ($errors) {
            return $errors;
        }

        $time_start = new \DateTime(date('Y-m-d').' '.$card_data['time_start']);
        $time_end = new \DateTime(date('Y-m-d').' '.$card_data['time_end']);
        if ($time_start->getTimestamp() > $time_end->getTimestamp()) {
            $errors[] = ['time_start' => 'Время начала больше чем время окончания'];
            return $errors;
        }

        if ($all_schedule_data) {
            foreach ($all_schedule_data as $schedule_data) {
                if ($schedule_data['time_start'] && $schedule_data['time_end']) {
                    $valid_time_start = new \DateTime(date('Y-m-d').' '.$schedule_data['time_start']);
                    $valid_time_end = new \DateTime(date('Y-m-d').' '.$schedule_data['time_end']);
                    if (
                        $schedule_data['user'] == $card_data['user'] &&
                        $time_start <= $valid_time_end && $valid_time_start <= $time_end
                    ) {
                        $errors[] = ['user' => 'Этот преподаватель пересекается с '.$schedule_data['cardName']];
                        break;
                    }
                }
            }
        }


        return $errors;
    }

}
