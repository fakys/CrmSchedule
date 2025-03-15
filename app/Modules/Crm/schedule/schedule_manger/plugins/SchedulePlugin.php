<?php
namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Src\BackendHelper;
use App\Src\modules\plugins\AbstractPlugin;


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
            $this->addSchedule(
                new \DateTime($scheduleRepository->date_start),
                $scheduleRepository->group_id,
                $scheduleRepository,
                false
            );
        }
    }
}
