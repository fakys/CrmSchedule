<?php

namespace App\Modules\Crm\schedule\repositories;

use App\Entity\Schedule;
use App\Src\BackendHelper;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class ScheduleRepository extends AbstractRepositories
{

    /**
     * Возвращает готовые юниты по дате и группе
     * @param $date_start
     * @param $date_end
     * @param $group_id
     * @return array
     */
    public function getScheduleUnitsByDate($date_start, $date_end, $group_id)
    {
        $sql = "WITH max_min_pair_number as  (
    select
        min(pair_numbers.number) as min_pair,
        max(pair_numbers.number) as max_pair
    from pair_numbers
)SELECT
     date,
     plan_schedule.id AS plan_schedule_id,
     plan_schedule.plan_duration_lesson_id AS plan_duration_lesson_id,
     plan_schedule.lessons_id AS lessons_id,
     plan_schedule.plan_type_id AS plan_type_id,
     plan_schedule.description AS schedule_description,
     CASE
         WHEN d_lessons.id IS NOT NULL THEN d_lessons.time_start
         ELSE p_d_lessons.time_start
         END AS schedule_time_start,

     CASE
         WHEN d_lessons.id IS NOT NULL THEN NULL
         ELSE p_d_lessons.week_number
         END AS schedule_week_number,
     CASE
         WHEN d_lessons.id IS NOT NULL THEN NULL
         ELSE p_d_lessons.week_day
         END AS schedule_week_day,
     CASE
         WHEN d_lessons.id IS NOT NULL THEN d_lessons.duration_minutes
         ELSE p_d_lessons.duration_minutes
         END AS schedule_duration_minutes,
     CASE
         WHEN d_lessons.id IS NOT NULL THEN d_lessons.time_end
         ELSE p_d_lessons.time_end
         END AS schedule_time_end,
     pn.id AS pair_id,
     pn.name AS pair_name,
     pn.number AS pair_number,
     s_group.id AS group_id,
     s_group.name AS group_name,
     s_group.number AS group_number,
     s_group.specialty_id AS specialty_id,
     specialties.name AS specialty_name,
     specialties.number AS specialty_number,
     specialties.description AS specialty_description,
     current_semester.id as semester_id,
     current_semester.name as semester_name,
     current_semester.date_start as semester_start,
     current_semester.date_end as semester_end,
     plan_type.name AS type_name,
     plan_type.plan_type_data AS type_data,
     lessons.format_lesson_id AS format_lesson_id,
     lessons.subject_id AS subject_id,
     lessons.user_id AS teacher_id,
     format_lessons.name AS format_name,
     format_lessons.description AS format_description,
     teachear.username AS username,
     teachear.blocked AS user_blocked,
     users_info.first_name || ' ' || users_info.last_name || ' ' || users_info.patronymic AS teacher_fio,
     users_info.email AS teacher_email,
     users_info.number_phone AS teacher_number_phone
FROM generate_series(:date_start::DATE, :date_end::DATE, '1 day'::INTERVAL) AS date
         CROSS JOIN generate_series((SELECT min_pair FROM max_min_pair_number), (SELECT max_pair FROM max_min_pair_number)) AS pair_number
         JOIN semesters current_semester on current_semester.id =  (select max(id) as id from semesters s where s.date_start::DATE <= date and s.date_end::DATE >= date)
    --План расписания
         LEFT JOIN plan_schedule ON plan_schedule.id = (select max(ps.id) as id FROM plan_schedule ps
                                                                                         LEFT JOIN plan_duration_lessons ON plan_duration_lessons.id = ps.plan_duration_lesson_id
                                                                                         LEFT JOIN pair_numbers p_n ON p_n.id = ps.pair_number_id
                                                        WHERE plan_duration_lessons.week_day = EXTRACT(DOW FROM date)
                                                          and ps.student_group_id = :group_id and plan_schedule.semester_id = current_semester.id
                                                          and p_n.number = pair_number)

    --Расписание
         LEFT JOIN schedules schedule on schedule.id = (select max(sched.id) as id from schedules sched
                                                                                            LEFT JOIN duration_lessons ON duration_lessons.id = sched.duration_lesson_id
                                                                                            LEFT JOIN pair_numbers p_n ON p_n.id = sched.pair_number_id
                                                        WHERE p_n.number = pair_number and date(date) = duration_lessons.date_start::date and sched.student_group_id = :group_id)

         LEFT JOIN plan_duration_lessons p_d_lessons ON p_d_lessons.id = plan_schedule.plan_duration_lesson_id
         LEFT JOIN duration_lessons d_lessons ON d_lessons.id = schedule.duration_lesson_id
         LEFT JOIN pair_numbers pn ON pn.number = pair_number
         LEFT JOIN student_groups s_group ON s_group.id = COALESCE(schedule.student_group_id, plan_schedule.student_group_id, :group_id)
         LEFT JOIN specialties ON specialties.id = s_group.specialty_id
         LEFT JOIN schedule_plan_type plan_type ON plan_type.id = plan_schedule.plan_type_id
         LEFT JOIN lessons ON lessons.id = COALESCE(schedule.lessons_id, plan_schedule.lessons_id)
         LEFT JOIN format_lessons ON format_lessons.id = lessons.format_lesson_id
         LEFT JOIN users teachear ON teachear.id = lessons.user_id
         LEFT JOIN users_info ON users_info.user_id = teachear.id
WHERE plan_schedule.semester_id = current_semester.id
    AND p_d_lessons.week_day = EXTRACT(DOW FROM date)
   OR plan_schedule.id is null
ORDER BY date DESC;";

        $args_arr = [':date_start' => $date_start, ':date_end' => $date_end, ':group_id'=>$group_id];
        return DB::select($sql, $args_arr);
    }

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
            $group_str = implode(',', $groups_id);
            $sql .= " AND s_group.id in ($group_str)";
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
             schedule.plan_type_id as plan_type_id,
             schedule.lessons_id as lessons_id,
             schedule.plan_duration_lesson_id as duration_lesson_id,
             loan_less.week_day as week_day,
             loan_less.time_start as time_start,
             loan_less.time_end as time_end,
             loan_less.duration_minutes as duration_minutes,
             loan_less.week_number as week_number,
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
             semesters.name as semester_name,
             users_info.user_id as teacher_id,
             users_info.last_name || ' ' || users_info.first_name || ' ' || users_info.patronymic as fio_teacher,
             type.plan_type_data as type_prams
         FROM plan_schedule schedule
            LEFT JOIN plan_duration_lessons loan_less ON loan_less.id =  schedule.plan_duration_lesson_id
            LEFT JOIN pair_numbers ON pair_numbers.id = schedule.pair_number_id
            LEFT JOIN student_groups s_group ON s_group.id = schedule.student_group_id
            LEFT JOIN specialties ON specialties.id = s_group.specialty_id
            LEFT JOIN lessons ON lessons.id = schedule.lessons_id
            LEFT JOIN subjects ON subjects.id = lessons.subject_id
            LEFT JOIN users_info ON users_info.user_id = lessons.user_id
            LEFT JOIN semesters ON semesters.id = schedule.semester_id
            LEFT JOIN schedule_plan_type type on schedule.plan_type_id = type.id
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

    public function getName(): string
    {
        return 'schedule_repository';
    }
}
