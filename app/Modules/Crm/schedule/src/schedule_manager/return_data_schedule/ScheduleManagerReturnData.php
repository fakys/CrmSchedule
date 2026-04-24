<?php

namespace App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule;

use App\Modules\Crm\schedule\src\factories\CorrectionScheduleReturnDataFactory;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\BackendHelper;

class ScheduleManagerReturnData
{
    /**
     * @var Schedule $schedule
     */
    private $schedule;


    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getSchedule()
    {
        $schedule_return_data = [];

        foreach ($this->schedule->getScheduleUnits() as $unit) {
            $schedule_return_data
            [$unit->getGroup()][] = $unit;
        }

        return CorrectionScheduleReturnDataFactory::createSchedule($schedule_return_data);
    }

}
