<?php

namespace App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule;

use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\BackendHelper;

class ScheduleReturnData
{
    /**
     * @var Schedule $schedule
     */
    private $schedule;
    private $return_schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getScheduleData()
    {

    }
}
