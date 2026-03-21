<?php

namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;
use App\Modules\Crm\schedule\schedule_manger\plugins\abstracts\AbstractSchedulePlugin;
use App\Modules\Crm\schedule\src\schedule_manager\entity\units\SemesterUnit;
use App\Src\BackendHelper;

/**
 * Создает базовое расписание
 */
class BaseSchedulePlugin extends AbstractSchedulePlugin
{

    public function getTag()
    {
        return 'schedule_manger';
    }

    public function getName(): string
    {
        return 'base_schedule_plugin';
    }

    public function index()
    {
        return 0;
    }

    /**
     * @throws \DateMalformedStringException
     * @throws ScheduleManagerException
     */
    public function Execute()
    {
        $current_date = clone $this->getSearchData()->getDateStart();
        $date_end = clone $this->getSearchData()->getDateEnd();

        while ($current_date < $date_end) {
            $current_semester = $this->getSemesters()->getSemesterByDate($current_date);

            foreach ($this->getPairNumbers()->getPairNumbers() as $number) {

                foreach ($this->getSearchData()->getGroupsId() as $groupId) {
                    $unit = $this->addUnit(
                        clone $current_date,
                        $number['number'],
                        $groupId,
                        $this->getSemesters()->getSemesterByDate($current_date)['id'],
                        $this->getNumberWeekBySemester(
                            clone $current_date,
                            $current_semester['date_start'],
                            count($this->getSchedulePlan()->getPlanScheduleBySemesterAndGroup($current_semester['id'], $groupId))
                        ),
                        $current_date->format('w')
                    );
                }
            }

            /** todo Тут бы в настройку вынести */
            $current_date->modify('+1 day');
        }
//        dd($this->getSchedule());
        return $this->getSchedule();
    }

    /**
     * @param \DateTime $date
     * @param SemesterUnit $semester_unit
     * @return int
     */
    public function getNumberWeekBySemester($date, $semester_start, $weeks)
    {
        return BackendHelper::getOperations()->getCurrentWeek(
            $date,
            new \DateTime($semester_start),
            $weeks > 0 ? $weeks : 1
        );
    }
}
