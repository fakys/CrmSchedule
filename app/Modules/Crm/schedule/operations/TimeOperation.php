<?php
namespace App\Modules\Crm\schedule\operations;

use App\Src\modules\operations\AbstractOperation;

class TimeOperation extends AbstractOperation{


    /**
     * Возвращает период
     * @param $period
     * @return \DateTime[]
     */
    public function pacePeriod($period)
    {
        $arr_period = explode(' - ', $period);
        $date_1 = trim($arr_period[0]);
        $date_2 = trim($arr_period[1]);
        return [new \DateTime($date_1), new \DateTime($date_2)];
    }

    public function getName(): string
    {
        return 'time_operation';
    }
}
