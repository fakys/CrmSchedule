<?php
namespace App\Modules\Crm\schedule_plan\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class SchedulePlan extends Operation{

    /**
     * Добавляет план расписания
     * @param $data
     * @param $type_id
     * @param $group_id
     * @param $semester_id
     * @return void
     */
    public function addSchedulePlan($data, $group_id, $type_id, $semester_id)
    {
        foreach ($data as$week_number=>$plan) {
            foreach ($plan as$day_number=>$day_week) {
                foreach ($day_week as $number => $pair) {
                    $pair_number = BackendHelper::getRepositories()->getPairByNumber($number);
                    $duration_min = (new \DateTime($pair['time_end']))->diff(new \DateTime($pair['time_start']))->i;
                    $duration_lessons = BackendHelper::getRepositories()->addPlanDurationLessons(
                        $day_number,
                        (new \DateTime($pair['time_start']))->format("H:i:s"),
                        (new \DateTime($pair['time_end']))->format("H:i:s"),
                        $week_number,
                        $duration_min,
                    );

                    $lessons = BackendHelper::getRepositories()
                        ->createLessons($pair['subject_id'], $pair['format_lesson_id'], $pair['user_id']);

                    if ($duration_lessons && $lessons) {
                        BackendHelper::getRepositories()->addSchedulePlan(
                            $duration_lessons->id,
                            $pair_number->id,
                            $group_id,
                            $semester_id,
                            $type_id,
                            $lessons->id,
                            $pair['schedule_description']
                        );
                    } else {
                        throw new SchedulePlanAddException('Ошибка во время создания');
                    }

                }
            }
        }


    }
}
