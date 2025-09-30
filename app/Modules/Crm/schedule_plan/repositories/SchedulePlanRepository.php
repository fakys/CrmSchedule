<?php

namespace App\Modules\Crm\schedule_plan\repositories;

use App\Entity\PlanDurationLesson;
use App\Entity\PlanSchedule;
use App\Entity\SchedulePlanType;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;

class SchedulePlanRepository extends AbstractRepositories
{
    /**
     * Создает длительность пары для плана
     * @param $week_day
     * @param $time_start
     * @param $time_end
     * @param $week_number
     * @param $duration_minutes
     * @return PlanDurationLesson|false
     */
    public function addPlanDurationLessons($week_day, $time_start, $time_end, $week_number, $duration_minutes = null)
    {
        $duration = new PlanDurationLesson();
        $duration->time_start = $time_start;
        $duration->time_end = $time_end;
        $duration->week_number = $week_number;
        $duration->week_day = $week_day;
        $duration->duration_minutes = $duration_minutes;
        if ($duration->save()) {
            return $duration;
        }
        return false;
    }

    /**
     * Обновляет длительность пары для плана
     * @param $id
     * @param $week_day
     * @param $time_start
     * @param $time_end
     * @param $week_number
     * @param $duration_minutes
     * @return PlanDurationLesson|false
     */
    public function updatePlanDurationLessons($id, $week_day, $time_start, $time_end, $week_number, $duration_minutes = null)
    {
        $duration = PlanDurationLesson::where(['id'=>$id])->first();
        $duration->time_start = $time_start;
        $duration->time_end = $time_end;
        $duration->week_number = $week_number;
        $duration->week_day = $week_day;
        $duration->duration_minutes = $duration_minutes;
        if ($duration->save()) {
            return $duration;
        }
        return false;
    }


    /**
     * Создает план расписания
     * @param $plan_duration_lesson_id
     * @param $pair_number_id
     * @param $student_group_id
     * @param $semester_id
     * @param $plan_type_id
     * @param $lessons_id
     * @param $description
     * @return PlanSchedule|false
     */
    public function addSchedulePlan(
        $plan_duration_lesson_id,
        $pair_number_id,
        $student_group_id,
        $semester_id,
        $plan_type_id,
        $lessons_id,
        $description = ''
    )
    {
        $schedule = new PlanSchedule();
        $schedule->pair_number_id = $pair_number_id;
        $schedule->student_group_id = $student_group_id;
        $schedule->semester_id = $semester_id;
        $schedule->plan_duration_lesson_id = $plan_duration_lesson_id;
        $schedule->description = $description;
        $schedule->lessons_id = $lessons_id;
        $schedule->plan_type_id = $plan_type_id;
        if ($schedule->save()) {
            return $schedule;
        }
        return false;
    }

    /**
     * Обновление описания плана расписания для формы
     * @param $id
     * @param $description
     * @return PlanSchedule|false
     */
    public function updateDescriptionSchedulePlan(
        $id,
        $description
    )
    {
        $schedule = PlanSchedule::where(['id'=>$id])->first();
        $schedule->description = $description;
        if ($schedule->save()) {
            return $schedule;
        }
        return false;
    }

    /**
     * Получает первое расписание по группе в семестре
     * @param $group_id
     * @param $semester_id
     * @return mixed
     */
    public function getFirstPlanSchedule($group_id, $semester_id)
    {
        return PlanSchedule::where(['semester_id'=>$semester_id, 'student_group_id'=>$group_id])->first();
    }

    /**
     * Получает все планы расписания на семестр
     * @return PlanSchedule[]
     */
    public function getAllSchedulePlanBySemester($semester_id)
    {
        return PlanSchedule::where(['semester_id' => $semester_id])->get();
    }

    public function getName(): string
    {
        return 'schedule_plan_repository';
    }
}
