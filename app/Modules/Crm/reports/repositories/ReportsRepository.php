<?php
namespace App\Modules\Crm\reports\repositories;

use App\Entity\ScheduleTask;
use App\Src\modules\repository\AbstractRepositories;
use Illuminate\Support\Facades\DB;

class ReportsRepository extends AbstractRepositories {

    public function getReportForTeachers($date_start, $date_end, $group_id)
    {
        $sql = "WITH search_semesters as (
    select
        max(semesters.date_end) as max_date,
        min(semesters.date_start) as min_date
    from semesters where
        semesters.date_start <= :date_start
        AND semesters.date_end >= :date_end
    )select
        schedule.group_name,
        schedule.group_number,
        schedule.specialty_number as specialties_number,
        schedule.specialty_name as specialties_name,
        schedule.semester_name,
        SUM(CEIL(EXTRACT(EPOCH FROM (schedule.period_schedule_time_end::time - schedule.period_schedule_time_start::time)) / 3600)) as count_hours_period,
    ROUND(SUM(CEIL(EXTRACT(EPOCH FROM (schedule.schedule_time_end::time - schedule.schedule_time_start::time)) / 3600)) /
          FLOOR(((select max_date from search_semesters)::DATE::DATE - (select min_date from search_semesters)::DATE + 1) / 7)::NUMERIC, 2) AS average_count_hours_week,
        SUM(CEIL(EXTRACT(EPOCH FROM (schedule.schedule_time_end::time - schedule.schedule_time_start::time)) / 3600)) as count_hours_semester
    from (WITH max_min_pair_number as (
            select
                min(pair_numbers.number) as min_pair,
                max(pair_numbers.number) as max_pair
            from pair_numbers
                        ) SELECT
                           date,
                           current_semester.id as semester_id,
                           current_semester.name as semester_name,
                           CASE
                               WHEN d_lessons.id IS NOT NULL THEN d_lessons.time_end
                               ELSE p_d_lessons.time_end
                               END AS schedule_time_end,
                           CASE
                               WHEN d_lessons.id IS NOT NULL THEN d_lessons.time_start
                               ELSE p_d_lessons.time_start
                               END AS schedule_time_start,
                           CASE
                               WHEN periodd_lessons.id IS NOT NULL THEN periodd_lessons.time_start
                               WHEN period_p_d_lessons.id IS NOT NULL THEN period_p_d_lessons.time_start
                               END AS period_schedule_time_start,
                           CASE
                               WHEN periodd_lessons.id IS NOT NULL THEN periodd_lessons.time_end
                               WHEN period_p_d_lessons.id IS NOT NULL THEN period_p_d_lessons.time_end
                               END AS period_schedule_time_end,
                           s_group.number as group_number,
                           s_group.number as group_name,
                           specialties.name as specialty_name,
                           specialties.number as specialty_number
                       FROM generate_series((select min_date from search_semesters)::DATE, (select max_date from search_semesters)::DATE, '1 day'::INTERVAL) AS date
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

                                LEFT JOIN plan_duration_lessons period_p_d_lessons ON period_p_d_lessons.id = plan_schedule.plan_duration_lesson_id and date >= :date_start and date <= :date_end
                                LEFT JOIN duration_lessons periodd_lessons ON periodd_lessons.id = schedule.duration_lesson_id and date >= :date_start and date <= :date_end
                       WHERE plan_schedule.semester_id = current_semester.id
                           AND p_d_lessons.week_day = EXTRACT(DOW FROM date)) schedule
    GROUP BY semester_name, group_number, group_name, specialty_name, specialty_number;";

        $args_arr = [':date_start' => $date_start, ':date_end' => $date_end, ':group_id'=>$group_id];
        return DB::select($sql, $args_arr);
    }

    public function getName(): string
    {
        return 'abstract_repositories';
    }
}
