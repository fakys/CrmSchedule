<?php
namespace App\Modules\Crm\holidays\operations;


use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class HolidayOperation extends AbstractOperation {

    /**
     * @return array
     * @throws \DateMalformedStringException
     */
    public function getHolidaysForTable()
    {
        $holidays = BackendHelper::getRepositories()->getAllHolidays();
        $main_data = [];

        foreach ($holidays as $holiday) {
            $date_start = new \DateTime($holiday->date_start);
            $date_end = new \DateTime($holiday->date_end);
            if ($date_end->format('Y') == $date_start->format('Y')) {
                $main_data[$date_start->format('Y')][] = $holiday;
            } else {
                $main_data[$date_start->format('Y').' - '.$date_end->format('Y')][] = $holiday;
            }
        }

        return $main_data;
    }

    public function getName(): string
    {
        return 'holiday_operation';
    }
}
