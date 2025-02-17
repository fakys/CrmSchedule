<?php
namespace App\Modules\Crm\schedule\src;

use App\Modules\Crm\schedule\src\entity\ScheduleDays;
use App\Src\BackendHelper;

/**
 * Используется для группировки расписания
 */
class ScheduleManager {
    /**
     * @var \DateTime $date_start
     */
    private $date_start;
    /**
     * @var \DateTime $date_end
     */
    private $date_end;

    /**
     * @var array $groups
     */
    private $groups;

    /**
     * @var array $specialties
     */
    private $specialties;

    /**
     * @var array $schedule
     */
    private $schedule;

    /**
     * @param \DateTime[] $period
     * @param $groups
     * @param $specialties
     */
    public function __construct($period, $groups, $specialties)
    {
        $this->date_start = $period[0]->setTime(0, 0, 0);
        $this->date_end = $period[1]->setTime(23, 59, 59);
        $this->groups = $groups;
        $this->specialties = $specialties;
    }


    public function getSchedule()
    {
        return $this->constructSchedule();
    }


    /**
     * Функция возвращает сконфигурированное расписание
     * @return array
     */
    private function constructSchedule()
    {
        if ($this->groups) {
             $this->constructScheduleByGroups();
        } elseif ($this->specialties) {

        } else {

        }
        return $this->schedule;
    }


    private function constructScheduleByGroups()
    {
        foreach ($this->groups as $group_id) {
            $report_data = BackendHelper::getRepositories()->getScheduleByGroupFroManager($this->date_start, $this->date_end, $group_id);
            $this->createScheduleDays($report_data, $group_id);
        }

    }


    private function createScheduleDays($report_data, $group_id)
    {
        $schedule_days = new ScheduleDays($this->date_start, $this->date_end, $report_data, $group_id);
        $schedule_days->createBadeScheduleDays();
        $this->schedule[] = $schedule_days->getSchedule();
    }
}
