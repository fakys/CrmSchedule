<?php

namespace App\Modules\Crm\schedule\components\schedule_manger\plugins;

use App\Entity\PlanSchedule;
use App\Modules\Crm\schedule\components\schedule_manger\plugins\abstracts\AbstractSchedulePlugin;
use App\Modules\Crm\schedule\Entity\CorrectionSchedule;
use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;
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
        $schedule_plan_type_by_semester = [];

        while ($current_date < $date_end) {
            $current_semester = $this->getSemesters()->getSemesterByDate($current_date);
            foreach ($this->getSearchData()->getGroupsId() as $groupId) {
                $schedule_plan_type_by_semester[$current_semester['id']][$groupId] = BackendHelper::getRepositories()->getSchedulePlanTypeByGroupSemester(
                    $current_semester['id'],
                    $groupId,
                );
                foreach ($this->getPairNumbers()->getPairNumbers() as $number) {
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
                    $unit->setBaseSchedule(true);
                    $unit->setSchedulePlanType($schedule_plan_type_by_semester[$current_semester['id']][$groupId]);

                    /** @var CorrectionSchedule $schedule */
                    $schedule = $this->getChangeScheduleEntity()->getScheduleByData(
                        $groupId,
                        $current_date,
                        $number['number'],
                    );

                    if (!$schedule) {
                        /** @var CorrectionSchedule $schedule */
                        $schedule = $this->getSchedulePlan()->getPlanScheduleByData(
                            $current_semester['id'],
                            $unit->getGroup(),
                            $unit->getWeekNumber(),
                            $unit->getWeekDay(),
                            $unit->getPairNumber()
                        );
                    }
                    if ($schedule) {
                        $unit->setTimeStart($schedule->schedule()->first()->getDuration()->time_start);
                        $unit->setTimeEnd($schedule->schedule()->first()->getDuration()->time_end);
                        $unit->setSubject($schedule->schedule()->first()->getLesson()->subject_id);
                        $unit->setUser($schedule->schedule()->first()->getLesson()->user_id);
                        $unit->setDescription($schedule->schedule()->first()->description);
                        $unit->setFormatPair($schedule->schedule()->first()->format_lesson_id);
                        $unit->setBaseSchedule(false);
                    }
                }
            }

            /** todo Тут бы в настройку вынести */
            $current_date->modify('+1 day');
        }
        return $this->getSchedule();
    }


    public function getNumberWeekBySemester($date, $semester_start, $weeks)
    {
        return BackendHelper::getOperations()->getCurrentWeek(
            $date,
            new \DateTime($semester_start),
            $weeks > 0 ? $weeks : 1
        );
    }
}
