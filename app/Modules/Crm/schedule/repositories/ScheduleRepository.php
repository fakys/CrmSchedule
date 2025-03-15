<?php

namespace App\Modules\Crm\schedule\repositories;

use App\Entity\Schedule;
use App\Src\BackendHelper;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class ScheduleRepository extends Repository
{


    public function getScheduleByGroupFroManager($date_start, $date_end, $groups_id = null)
    {
        $sql = "
         SELECT
             schedule.id,
             schedule.description as schedule_description,
             loan_less.date_start as date_start,
             loan_less.time_start as time_start,
             loan_less.time_end as time_end,
             loan_less.duration_minutes as duration_minutes,
             pair_numbers.id as pair_id,
             pair_numbers.number::integer as pair_number,
             pair_numbers.name as pair_number_name,
             s_group.id as group_id,
             s_group.number as group_number,
             s_group.name as group_name,
             specialties.number as specialties_number,
             specialties.name as specialties_name,
             specialties.description as specialties_description,
             subjects.id as subject_id,
             subjects.name as subject_name,
             subjects.full_name as subject_full_name,
             subjects.description as subject_description,
             lessons.format_lesson_id as format_id,
             users_info.user_id as teacher_id,
             users_info.last_name || ' ' || users_info.first_name || ' ' || users_info.patronymic as fio_teacher
         FROM schedules schedule
            LEFT JOIN duration_lessons loan_less ON loan_less.id =  schedule.duration_lesson_id
            LEFT JOIN pair_numbers ON pair_numbers.id = schedule.pair_number_id
            LEFT JOIN student_groups s_group ON s_group.id = schedule.student_group_id
            LEFT JOIN specialties ON specialties.id = s_group.specialty_id
            LEFT JOIN lessons ON lessons.id = schedule.lessons_id
            LEFT JOIN subjects ON subjects.id = lessons.subject_id
            LEFT JOIN users_info ON users_info.user_id = lessons.user_id
         WHERE loan_less.date_start >= :date_start AND loan_less.date_start <= :date_end";

        $args_arr = [':date_start' => $date_start, ':date_end' => $date_end];

        if ($groups_id && is_array($groups_id)) {
            $sql .= " AND s_group.id in (:group_id)";
            $args_arr[':group_id'] = implode(',', $groups_id);
        } elseif ($groups_id) {
            $sql .= " AND s_group.id in (:group_id)";
            $args_arr[':group_id'] = $groups_id;
        }

        return DB::select($sql, $args_arr);
    }

    /**
     * Получает план расписания
     * @param $group_id
     * @param $semester_id
     * @return array
     */
    public function getPlanScheduleByGroupFroManager($group_id, $semester_id)
    {
        $sql = "
         SELECT
             schedule.id,
             schedule.description as schedule_description,
             loan_less.week_day as week_day,
             loan_less.time_start as time_start,
             loan_less.time_end as time_end,
             loan_less.duration_minutes as duration_minutes,
             pair_numbers.id as pair_id,
             pair_numbers.number::integer as pair_number,
             pair_numbers.name as pair_number_name,
             s_group.id as group_id,
             s_group.number as group_number,
             s_group.name as group_name,
             specialties.number as specialties_number,
             specialties.name as specialties_name,
             specialties.description as specialties_description,
             subjects.id as subject_id,
             subjects.name as subject_name,
             subjects.full_name as subject_full_name,
             subjects.description as subject_description,
             lessons.format_lesson_id as format_id,
             semesters.id as semester_id,
             users_info.user_id as teacher_id,
             users_info.last_name || ' ' || users_info.first_name || ' ' || users_info.patronymic as fio_teacher
         FROM plan_schedule schedule
            LEFT JOIN plan_duration_lessons loan_less ON loan_less.id =  schedule.plan_duration_lesson_id
            LEFT JOIN pair_numbers ON pair_numbers.id = schedule.pair_number_id
            LEFT JOIN student_groups s_group ON s_group.id = schedule.student_group_id
            LEFT JOIN specialties ON specialties.id = s_group.specialty_id
            LEFT JOIN lessons ON lessons.id = schedule.lessons_id
            LEFT JOIN subjects ON subjects.id = lessons.subject_id
            LEFT JOIN users_info ON users_info.user_id = lessons.user_id
            LEFT JOIN semesters ON semesters.id = schedule.semester_id
         WHERE s_group.id = :group_id AND semesters.id = :semester_id";

        $args_arr = [':group_id' => $group_id, 'semester_id'=>$semester_id];

        return DB::select($sql, $args_arr);
    }


    /**
     * Получает расписание по данным
     * @param $date
     * @param $group_id
     * @param $pair_number_id
     * @return array
     */
    public function getScheduleByDate($date, $group_id, $pair_number_id)
    {
        $sql = "SELECT schedules.id as id,
           schedules.duration_lesson_id,
           schedules.pair_number_id,
           schedules.student_group_id,
           schedules.description
        FROM schedules
         LEFT JOIN duration_lessons duration ON duration.id = schedules.duration_lesson_id
         WHERE schedules.student_group_id = :group_id AND
               schedules.pair_number_id = :pair_number_id AND
               duration.date_start = :date_start";

        $args_arr = [':group_id' => $group_id, ':pair_number_id' => $pair_number_id, ':date_start' => $date];

        return DB::select($sql, $args_arr);
    }

    /**
     * Создает расписание
     * @param $duration_lesson_id
     * @param $pair_number_id
     * @param $student_group_id
     * @param $lessons_id
     * @param $description
     * @return Schedule|null
     */
    public function createSchedule($duration_lesson_id, $pair_number_id, $student_group_id, $lessons_id, $description = '')
    {
        $new_schedule = new Schedule();
        $new_schedule->duration_lesson_id = $duration_lesson_id;
        $new_schedule->pair_number_id = $pair_number_id;
        $new_schedule->student_group_id = $student_group_id;
        $new_schedule->lessons_id = $lessons_id;
        $new_schedule->description = $description;
        if ($new_schedule->save()) {
            return $new_schedule;
        }
        return null;
    }


    /**
     * Получает расписание по id
     * @param $id
     * @return Schedule
     */
    public function getSchedulesById($id)
    {

        return Schedule::where(['id' => $id])->first();
    }

    /**
     * Обновляет данные по id и entity
     * @param $data
     * @param $field_name
     * @param $entity
     * @return mixed
     */
    public function updateDataByEntity($data, $field_name, $entity)
    {
        $entity->{$field_name} = $data;
        if ($entity->save()) {
            return $entity;
        }
        return null;
    }

    /**
     * Удаляет расписание по id
     * @param $id
     * @return bool
     */
    public function deleteScheduleById($id)
    {
        return Schedule::where(['id' => $id])->first()->delete();
    }

}
