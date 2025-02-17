<?php
namespace App\Modules\Crm\schedule\repositories;

use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class ScheduleRepository extends Repository {


    public function getScheduleByGroupFroManager($date_start, $date_end, $group_id = null)
    {
        $sql = "
         SELECT
             schedule.id,
             schedule.description as schedule_description,
             loan_less.date_start as date_start,
             loan_less.time_start as time_start,
             loan_less.time_end as time_end,
             loan_less.duration_minutes as duration_minutes,
             pair_numbers.number::integer as pair_number,
             pair_numbers.name as pair_number_name,
             s_group.id as group_id,
             s_group.number as group_number,
             s_group.name as group_name,
             specialties.number as specialties_number,
             specialties.name as specialties_name,
             specialties.description as specialties_description,
             subjects.name as subject_name,
             subjects.full_name as subject_full_name,
             subjects.description as subject_description,
             users_info.last_name || ' ' || users_info.first_name || ' ' || users_info.patronymic as fio_teacher
         FROM schedules schedule
            LEFT JOIN duration_lessons loan_less ON loan_less.id =  schedule.duration_lesson_id
            LEFT JOIN pair_numbers ON pair_numbers.id = schedule.pair_number_id
            LEFT JOIN student_groups s_group ON s_group.id = schedule.student_group_id
            LEFT JOIN specialties ON specialties.id = s_group.specialty_id
            LEFT JOIN lessons ON lessons.id = schedule.lessons_id
            LEFT JOIN subjects ON subjects.id = lessons.subject_id
            LEFT JOIN users_info ON users_info.user_id = lessons.user_id
         WHERE loan_less.date_start >= :date_start AND loan_less.date_start <= :date_end AND s_group.id = :group_id";

        $args_arr = [':date_start'=>$date_start, ':date_end'=>$date_end, ':group_id'=>$group_id];

        return DB::select($sql, $args_arr);
    }
}
