<?php

namespace App\Modules\Crm\schedule_plan\components\repositories;

use App\Entity\PlanDurationLesson;
use App\Entity\PlanSchedule;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;
use Illuminate\Database\Query\Builder;

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
     * @param $semester_id
     * @param $plan_type_id
     * @return PlanSchedule|false
     */
    public function addSchedulePlan(
        $schedule_id,
        $semester_id,
        $plan_type_id,
        $week_day,
        $week_number,
    )
    {
        $schedule = new PlanSchedule();
        $schedule->semester_id = $semester_id;
        $schedule->plan_type_id = $plan_type_id;
        $schedule->week_day = $week_day;
        $schedule->week_number = $week_number;
        $schedule->schedule_id = $schedule_id;
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
     * @param $teacherId
     * @param $week_day
     * @param $week_number
     * @param $semester_id
     * @param $numberPair
     * @param array $exceptionGroups
     * @return PlanSchedule|null
     */
    public function getPlanScheduleByDayAndException(
        $teacherId,
        $week_day,
        $week_number,
        $semester_id,
        $numberPair,
        array $exceptionGroups
    )
    {
//        dd(PlanSchedule::query()
//            ->with('schedule')
//            ->with('schedule.pairNumber')
//            ->with('schedule.lesson')
//            ->whereHas('schedule', function ($query) use ($exceptionGroups, $semester_id, $numberPair, $teacherId) {
//                /** @var Builder $query */
//                $query->whereIn('student_group_id', $exceptionGroups, 'and', true);
//                $query->whereHas('pairNumber', function ($query) use ($numberPair) {
//                    $query->where('number', $numberPair);
//                });
//                $query->whereHas('lesson', function ($query) use ($teacherId) {
//                    $query->where('user_id', $teacherId);
//                });
//            })->where('semester_id', $semester_id)
//            ->where('week_day', $week_day)
//            ->where('week_number', $week_number)->ddRawSql());
        return PlanSchedule::query()
            ->with('schedule')
            ->with('schedule.pairNumber')
            ->with('schedule.lesson')
            ->whereHas('schedule', function ($query) use ($exceptionGroups, $semester_id, $numberPair, $teacherId) {
                /** @var Builder $query */
                $query->whereIn('student_group_id', $exceptionGroups, 'and', true);
                $query->whereHas('pairNumber', function ($query) use ($numberPair) {
                    $query->where('number', $numberPair);
                });
                $query->whereHas('lesson', function ($query) use ($teacherId) {
                    $query->where('user_id', $teacherId);
                });
            })->where('semester_id', $semester_id)
            ->where('week_day', $week_day)
            ->where('week_number', $week_number)->first();
    }

    /**
     * Получает план по группам и семестру
     * @param $groups_id
     * @param $semester_id
     * @return  PlanSchedule[]
     *
     */
    public function getPlanScheduleByGroups($groups_id, $semester_id)
    {
        return PlanSchedule::query()
            ->with('schedule')
            ->whereHas('schedule', function ($query) use ($groups_id, $semester_id) {
                $query->whereIn('student_group_id', $groups_id);
            })->where('semester_id', $semester_id)
            ->get();
    }

    public function deletePlanScheduleByGroups($groups_id, $semester_id)
    {
        return PlanSchedule::query()
            ->with('schedule')
            ->whereHas('schedule', function ($query) use ($groups_id, $semester_id) {
                $query->where(['student_group_id'=>$groups_id]);
            })->where('semester_id', $semester_id)
            ->delete();
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
