<?php

namespace App\Modules\Crm\schedule_plan\repositories;

use App\Entity\SchedulePlanType;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class SchedulePlanTypeRepository extends Repository
{
    /**
     * Создает тип плана расписания
     * @param string $name
     * @param string $data
     * @return SchedulePlanType|false
     */
    public function addSchedulePlanType($name, $data)
    {
        $type = new SchedulePlanType();
        $type->name = $name;
        $type->plan_type_data = $data;

        if ($type->save()) {
            return $type;
        }
        return false;
    }

    /**
     * Возвращает все типы планов расписания
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allSchedulePlanType()
    {
        return SchedulePlanType::all();
    }

    /**
     * Получает тип плана расписания по id
     * @param $id
     * @return mixed
     */
    public function getSchedulePlanTypeById($id)
    {
        return SchedulePlanType::where(['id'=>$id])->first();
    }

    /**
     * Изменяет тип плана расписания по id
     * @param $id
     * @param $name
     * @param $data
     * @return bool
     */
    public function editSchedulePlanTypeById($id, $name, $data)
    {
        $type = SchedulePlanType::where(['id'=>$id])->first();
        $type->name = $name;
        $type->plan_type_data = json_encode($data);
        if ($type->save()) {
            return true;
        }
        return false;
    }

    /**
     * Возвращает план по семестру и группе
     * @param $semester_id
     * @param $group_id
     * @return array
     */
    public function getSchedulePlanTypeByGroupSemester($semester_id, $group_id)
    {
        $sql = "SELECT
            type.id,
            type.name,
            type.plan_type_data
         FROM plan_schedule schedule
         LEFT JOIN schedule_plan_type type on schedule.plan_type_id = type.id
         WHERE schedule.student_group_id = :group_id AND schedule.semester_id = :semester_id
         ORDER BY schedule.id DESC LIMIT 1";

        $args_arr = [':group_id'=>$group_id, ':semester_id'=>$semester_id];
        return DB::selectOne($sql, $args_arr);
    }
}
