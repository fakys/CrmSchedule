<?php

namespace App\Modules\Crm\schedule\models;

use App\Modules\Crm\schedule\exceptions\ScheduleEditValidException;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use function Symfony\Component\String\b;

/**
 * @property string $number
 * @property string $full_name
 * @property string $description
 */
class EditScheduleModel extends Model implements InterfaceModel
{

    public $schedule;
    public $error_schedule;
    public function fields(): array
    {
        return [
        ];
    }

    public function rules(): array
    {
        return [
        ];
    }

    public function boolean(): array
    {
        return [

        ];
    }


    /**
     * Удаляет пустые расписания
     * @return array
     */
    public function deleteEmptySchedule()
    {
        /** Проходимся по пустым расписаниям */
        foreach ($this->schedule as  $schedule_old_group => $schedule_group) {
            $group_name = BackendHelper::getRepositories()->getStudentGroupById($schedule_old_group)->number;
            foreach ($schedule_group as $schedule_old_date => $new_schedule_pairs) {
                foreach ($new_schedule_pairs as $pair_number => $schedule_new) {
                    if (
                        $schedule_new['schedule']['format_lesson_id'] == 0 &&
                        $schedule_new['schedule']['subject_id'] == 0 &&
                        !$schedule_new['schedule']['time_end'] &&
                        !$schedule_new['schedule']['time_start'] &&
                        $schedule_new['schedule']['user_id'] == 0
                    ) {
                        if (
                            $schedule_new['schedule']['format_lesson_id'] != 0 ||
                            $schedule_new['schedule']['subject_id'] != 0 ||
                            $schedule_new['schedule']['time_end'] ||
                            $schedule_new['schedule']['time_start'] ||
                            $schedule_new['schedule']['user_id'] != 0
                        ) {
                            $this->error_schedule[$group_name][$schedule_old_date][$pair_number] = 'Данные заполнены не полностью';
                            continue;
                        }
                        unset($this->schedule[$schedule_old_group][$schedule_old_date][$pair_number]);
                    }
                }
            }
        }
        /** Если есть пустые даты, убираем и их */
        foreach ($this->schedule as $schedule_old_group => $schedule_group) {
            foreach ($schedule_group as $schedule_old_date => $new_schedule_pairs) {
                if (!$new_schedule_pairs) {
                    unset($this->schedule[$schedule_old_group][$schedule_old_date]);
                }
            }
        }

        return $this->schedule;
    }

    public function hasSchedule()
    {
        if (!$this->schedule) {
            throw new ScheduleEditValidException(json_encode(['error' => true, 'err_data' => 'Данные не были переданы']), 400);
        }
        return true;
    }

    public function validate()
    {
        $this->hasSchedule();
        $this->deleteEmptySchedule();
        $setting_weekend = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName())->type_weeks;

        foreach ($this->schedule as  $schedule_old_group => $schedule_group) {
            $group_name = BackendHelper::getRepositories()->getStudentGroupById($schedule_old_group)->number;
            foreach ($schedule_group as $schedule_old_date => $new_schedule_pairs) {
                foreach ($new_schedule_pairs as $pair_number => $schedule_new) {
                    $time_start = new \DateTime(
                        sprintf(
                            "%s %s",
                            $schedule_new['date'],
                            $schedule_new['schedule']['time_start'],
                        )
                    );
                    $time_end = new \DateTime(
                        sprintf(
                            "%s %s",
                            $schedule_new['date'],
                            $schedule_new['schedule']['time_end']
                        )
                    );
                    $date_start = new \DateTime($schedule_new['schedule']['date_start']);

                    if ($time_start >= $time_end) {
                        $this->error_schedule[$group_name][$schedule_old_date][$pair_number] = 'Время начало больше времени окончания';
                        continue;
                    }

                    if (!\DateTime::createFromFormat('Y-m-d', $schedule_new['schedule']['date_start'])) {
                        $this->error_schedule[$group_name][$schedule_old_date][$pair_number] = 'Не верный формат даты';
                        continue;
                    }

                    if ($setting_weekend == ScheduleSetting::SIX_DAY) {
                        if ($date_start->format('w') == 0 || $date_start->format('w') == 6) {
                            $this->error_schedule[$group_name][$schedule_old_date][$pair_number] = 'Дата выпадает на выходные';
                            continue;
                        }
                    } else {
                        if ($date_start->format('w') == 0) {
                            $this->error_schedule[$group_name][$schedule_old_date][$pair_number] = 'Дата выпадает на выходные';
                            continue;
                        }
                    }

                    $schedule_by_date = $this->schedule[$schedule_old_group][$schedule_old_date];
                    foreach ( $schedule_by_date as  $pair => $valid_schedule_new) {
                        if ($pair_number != $pair) {
                            $valid_time_start = new \DateTime(
                                sprintf(
                                    "%s %s",
                                $valid_schedule_new['date'],
                                $valid_schedule_new['schedule']['time_start']
                                )
                            );
                            $valid_time_end = new \DateTime(
                                sprintf(
                                    '%s %s',
                                    $valid_schedule_new['date'],
                                    $valid_schedule_new['schedule']['time_end']
                                )
                            );
                            $pair_number_entity = BackendHelper::getRepositories()->getNumberPairById($pair);

                            if (
                                ($time_start >= $valid_time_start && $time_end <= $valid_time_end)
                            ) {
                                $this->error_schedule[$group_name][$schedule_old_date][$pair_number] =
                                    "Время начала и время окончания пересекаются с {$pair_number_entity->number} парой";
                                break;
                            }
                        }
                    }
                }
            }
        }
        if ($this->error_schedule) {
            throw new ScheduleEditValidException(json_encode(['error' => true, 'err_data' => $this->error_schedule]), 400);
        } else {
            return true;
        }

    }
}
