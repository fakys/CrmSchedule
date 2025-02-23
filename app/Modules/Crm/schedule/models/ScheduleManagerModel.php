<?php
namespace App\Modules\Crm\schedule\models;

use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $number
 * @property string $full_name
 * @property string $description
 */
class ScheduleManagerModel extends Model implements InterfaceModel
{
    public static function getRequiredFieldsForSchedule()
    {
        return [
            'date_start',
            'group_id',
            'pair_format',
            'pair_number',
            'schedule_description',
            'subjects',
            'time_end',
            'time_start',
            'users'
        ];
    }
    public function fields(): array
    {
        return [
            'period',
            'groups',
            'specialties'
        ];
    }

    public function rules(): array
    {
        return [
            'period' => ['required', 'string'],
            'groups' => ['array'],
            'specialties' => ['array'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    /**
     * Удаляет пустые расписания
     * @param $schedule
     * @return array
     */
    public function deleteEmptySchedule($schedule)
    {
        /** Проходимся по пустым расписаниям */
        foreach ($schedule as $schedule_old_group => $schedule_group) {
            foreach ($schedule_group as $schedule_old_date => $new_schedule_pairs) {
                foreach ($new_schedule_pairs as $pair_number => $schedule_new) {
                    if (
                        !$schedule_new['schedule']['date_start'] &&
                        !$schedule_new['schedule']['format_lesson_id'] != 0 &&
                        !$schedule_new['schedule']['group_id'] != 0 &&
                        !$schedule_new['schedule']['pair_number'] != 0 &&
                        !$schedule_new['schedule']['subject_id'] != 0 &&
                        !$schedule_new['schedule']['time_end'] &&
                        !$schedule_new['schedule']['time_start'] &&
                        !$schedule_new['schedule']['user_id'] != 0
                    ) {
                        unset($schedule[$schedule_old_group][$schedule_old_date][$pair_number]);
                    }
                }
            }
        }
        /** Если есть пустые даты, убираем и их */
        foreach ($schedule as $schedule_old_group => $schedule_group) {
            foreach ($schedule_group as $schedule_old_date => $new_schedule_pairs) {
                if (!$new_schedule_pairs) {
                    unset($schedule[$schedule_old_group][$schedule_old_date]);
                }
            }
        }

        return $schedule;
    }
}
