<?php
namespace App\Modules\Crm\schedule_plan\operation;

use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class SchedulePlanType extends AbstractOperation{

    /**
     * Добавляет тип плана расписания
     * @param array $data
     * @return true
     */
    public function addSchedulePlanType($data)
    {
        $name = $data['name'];
        $json_data = json_encode($data['data']);
        BackendHelper::getRepositories()->addSchedulePlanType($name, $json_data);
        return true;
    }

    /**
     * Форматирует дни недели
     * @return array
     */
    public function formatWeeks($weeks)
    {
        foreach ($weeks as $number => $week) {
            $week['week_end'][7] = $week['week_end'][0];
            unset($week['week_end'][0]);
            $weeks[$number] = $week;
        }
        return $weeks;
    }

    /**
     * Создает массив для конструктора
     * @param array $groups_id
     * @return array
     */
    public function getArrForScheduleConstruct($groups_id)
    {
        $data = [];
        if (count($groups_id) >= 3) {
            $groups_data = [];
            $count_for_arr = ceil(count($groups_id) / 3);
            $current_arr = 0;
            $current_index_arr = 0;
            foreach ($groups_id as $key=>$group_id) {
                $current_arr ++;
                $groups_data[$current_index_arr][] = $group_id;

                if ($current_arr >= $count_for_arr) {
                    $current_index_arr++;
                    $current_arr = 0;
                } elseif (count($groups_id) % $count_for_arr == 0 && empty($groups_id[$key+2])) { //Если число нацело делится и это предпоследний элемент
                    //Нужно что бы получить 3 массива
                    $current_index_arr++;
                    $current_arr = 0;
                }
            }
        } else {
            $groups_data = [$groups_id];
        }

        foreach ($groups_data as $key => $group_id) {
            $data[$key] = [];
            foreach ($group_id as $id) {
                $group = BackendHelper::getRepositories()->getStudentGroupById($id);
                $data[$key][] = $group;
            }
        }

        return $data;
    }

    public function getName(): string
    {
        return 'schedule_plan_type_operation';
    }
}
