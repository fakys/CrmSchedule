<?php

namespace App\Modules\Crm\schedule_plan\repositories;

use App\Entity\SchedulePlanType;
use App\Src\modules\repository\Repository;

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
}
