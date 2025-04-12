<?php
namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Src\BackendHelper;
use App\Src\modules\plugins\AbstractPlugin;
use function Symfony\Component\Translation\t;


/**
 * Плагин проставляющий выходные
 * @property ScheduleSearchData $searchData
 * @property Schedule $schedule
 * @property SemesterEntity $semesters
 * @property PairNumberEntity $pair_numbers
 * @property PlanScheduleEntity $planScheduleRepository
 * @property array $schedule_repositories
 */
class SchedulePlugin extends AbstractPlugin
{

    public function pluginName()
    {
        return 'schedule_plugin';
    }

    public function Execute()
    {
        $this->schedule_repositories = [];
        if ($this->searchData->getGroupsId()) {
            $this->schedule_repositories = BackendHelper::getRepositories()->getScheduleByGroupFroManager(
                $this->searchData->getDateStart(),
                $this->searchData->getDateEnd(),
                $this->searchData->getGroupsId()
            );
        } else if ($this->searchData->getSpecialtiesId()) {
            foreach ($this->searchData->getSpecialtiesId() as $specialtyId) {
                $specialty = BackendHelper::getRepositories()->getSpecialtyById($specialtyId);
                $groups = $specialty->getGroups();
                foreach ($groups as $group) {
                    $this->schedule_repositories = array_merge($this->schedule_repositories,
                        BackendHelper::getRepositories()->getScheduleByGroupFroManager(
                            $this->searchData->getDateStart(),
                            $this->searchData->getDateEnd(),
                            $group->id
                        )
                    );
                }
            }
        } else {
            $this->schedule_repositories = BackendHelper::getRepositories()->getScheduleByGroupFroManager(
                $this->searchData->getDateStart(),
                $this->searchData->getDateEnd()
            );
        }

        foreach ($this->schedule_repositories as $scheduleRepository) {
            $this->updateSchedule(
                new \DateTime($scheduleRepository->date_start),
                $scheduleRepository->group_id,
                $scheduleRepository
            );
        }
    }


    /**
     * Добавляет расписание
     * @param \DateTime $date
     * @param $schedule
     * @param $group_id
     * @return true
     */
    public function updateSchedule($date, $group_id, $schedule)
    {
        /** @var ScheduleUnit $schedule_unit */
        foreach ($this->schedule as $schedule_unit) {
            if (
                $schedule_unit->getDate()->format('Y-m-d') == $date->format('Y-m-d') &&
                $schedule_unit->getGroup() == $group_id &&
                $schedule_unit->getPairNumber() == $schedule->pair_number
            ) {
                $schedule_unit->setDate($date);
                $schedule_unit->setPairNumber($schedule->pair_number);
                $schedule_unit->setGroup($schedule->group_id);
                $schedule_unit->setTimeStart($schedule->time_start);
                $schedule_unit->setTimeEnd($schedule->time_end);
                $schedule_unit->setSubject($schedule->subject_id);
                $schedule_unit->setUser($schedule->teacher_id);
                $schedule_unit->setFormatPair($schedule->format_id);
                $schedule_unit->setDescription($schedule->schedule_description);
                $schedule_unit->setBaseSchedule(false);
                if (isset($schedule->semester_id)) {
                    $schedule_unit->setSemester($schedule->semester_id);
                } else {
                    $semester = BackendHelper::getRepositories()->getSemestersByDate($date);
                    $schedule_unit->setSemester($semester->id);
                }
                return true;
            }
        }
        return true;
    }
}
