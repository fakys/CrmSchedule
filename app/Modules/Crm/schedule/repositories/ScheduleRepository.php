<?php
namespace App\Modules\Crm\schedule\repositories;

use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class ScheduleRepository extends Repository {


    public function getScheduleByGroupFroManager($period, $group_id)
    {
        $sql = "
         SELECT
             schedule.id,
             schedule.description,
             duration_lessons.date_start,
             duration_lessons.time_start,
             duration_lessons.time_end,
             duration_lessons.duration_minutes,
             pair_numbers.number as pair_number,
             pair_numbers.name as pair_number_name,
             s_group.number as group_number,
             s_group.name as group_name,
             case
                 when specialties is not null
                     then
                     specialties.number as specialty_number,
                     specialties.name as specialty_name,
                     specialties.description as specialty_description,
             end
             schedule.description as specialty_description
         FROM schedules schedule
            LEFT JOIN duration_lessons loan_less ON loan_less.id =  schedule.duration_lesson_id
            LEFT JOIN pair_numbers ON pair_numbers.id = schedule.pair_number_id
            LEFT JOIN student_groups s_group ON s_group.id = schedule.student_group_id
            LEFT JOIN specialties ON specialties.id = s_group.specialty_id
            LEFT JOIN lessons ON lessons.id = schedule.lesson_id";

        return DB::select($sql);
    }
}
