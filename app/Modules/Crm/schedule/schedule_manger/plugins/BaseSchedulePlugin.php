<?php

namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Entity\PairNumber;
use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;
use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Src\BackendHelper;
use App\Src\modules\plugins\AbstractPlugin;

/**
 * Создает базовое расписание
 * @property ScheduleSearchData $searchData
 * @property Schedule $schedule
 * @property SemesterEntity $semesters
 * @property PairNumberEntity $pair_numbers
 * @property PlanScheduleEntity $planScheduleRepository
 */
class BaseSchedulePlugin extends AbstractPlugin
{

    public function pluginName()
    {
        return 'base_schedule_plugin';
    }

    /**
     * @throws \DateMalformedStringException
     * @throws ScheduleManagerException
     */
    public function Execute()
    {
        $this->initSearchData();
        $this->createSchedule();

        /** Заполняем сущности */
        $this->pair_numbers = new PairNumberEntity(BackendHelper::getRepositories()->getNumberPair());
        $this->semesters = new SemesterEntity(
            BackendHelper::getRepositories()->getSemestersByPeriod($this->searchData->getDateStart(), $this->searchData->getDateEnd())
        );

        /** Получаем данные из репозитория */
        foreach ($this->semesters->getSemesters() as $semester) {
            if ($this->searchData->getGroupsId()) {
                foreach ($this->searchData->getGroupsId() as $group) {
                    $this->appendArrProperty('planScheduleRepository',
                        new PlanScheduleEntity(BackendHelper::getRepositories()->getPlanScheduleByGroupFroManager(
                            $group,
                            $semester['id'])
                        ),
                        $group
                    );
                }
            } elseif ($this->searchData->getSpecialtiesId()) {
                foreach ($this->searchData->getSpecialtiesId() as $specialty) {
                    $specialty_obj = BackendHelper::getRepositories()->getSpecialtyById($specialty);
                    $groups = $specialty_obj->getGroups();
                    foreach ($groups as $group) {
                        $this->appendArrProperty('planScheduleRepository',
                            new PlanScheduleEntity(BackendHelper::getRepositories()->getPlanScheduleByGroupFroManager(
                                $group,
                                $semester['id'])
                            ),
                            $group
                        );
                    }
                }
            }
        }

        /** Прибавляем 1 т.к время с 00 до 23 и это не считается за день*/
        $count_days = $this->searchData->getDateStart()->diff($this->searchData->getDateEnd())->days + 1;
        $date_schedule = clone $this->searchData->getDateStart();
        for ($day = 1; $day <= $count_days; $day++) {
            /** Получаем текущий семестр */
            $semester = $this->semesters->getSemesterByDate($date_schedule);

            foreach ($this->searchData->getGroupsId() as $group) {
                for ($pair_number = 1; $pair_number <= count($this->pair_numbers->getPairNumbers()); $pair_number++) {
                    $this->addSchedule(
                        clone $date_schedule,
                        $group,
                        $this->planScheduleRepository[$group]->getPlanScheduleByData(
                            $group,
                            $semester['id'],
                            $pair_number,
                            $date_schedule->format('w')
                        )
                    );
                }
            }
            $date_schedule->modify("+1 day");
        }
        $this->setResult($this->schedule);
        return $this->schedule;
    }

    /**
     * Добавляет расписание
     * @param \DateTime $date
     * @param null $schedule
     */
    public function addSchedule($date, $group_id, $schedule = null)
    {
        if (!$schedule) {
            $schedule_unit = new ScheduleUnit();
            $schedule_unit->setDate($date);
            $schedule_unit->setPairNumber((int)$this->getFirstEmptyPairNumberByDate($date, $group_id)['number']);
            $schedule_unit->setSemester($this->semesters->getSemesterByDate($date)['id']);
            $schedule_unit->setGroup((int)$group_id);
            $this->schedule->addUnit($schedule_unit);
        } else {
            $schedule_unit = new ScheduleUnit();
            $schedule_unit->setDate($date);
            $schedule_unit->setPairNumber($schedule->pair_number);
            $schedule_unit->setSemester($schedule->semester_id);
            $schedule_unit->setGroup($schedule->group_id);
            $schedule_unit->setTimeStart($schedule->time_start);
            $schedule_unit->setTimeEnd($schedule->time_end);
            $schedule_unit->setSubject($schedule->subject_id);
            $schedule_unit->setUser($schedule->teacher_id);
            $schedule_unit->setFormatPair($schedule->format_id);
            $schedule_unit->setDescription($schedule->schedule_description);
            $this->schedule->addUnit($schedule_unit);
        }
    }

    private function createSchedule()
    {
        $this->schedule = new Schedule();
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Возвращает первую свободную пару ля группы на заданный день
     * @return PairNumber
     */
    private function getFirstEmptyPairNumberByDate(\DateTime $date, $group_id)
    {
        /** @var ScheduleUnit[] $schedule */
        $schedule = $this->getSchedule()->getScheduleUnitByDate($date, $group_id);
        $pair_number_count = 1;
        foreach ($schedule as $unit) {

            if (!$unit->getPairNumber()) {
                return $this->pair_numbers->getPairByNumber($pair_number_count);
            }
            $pair_number_count++;
        }
        $pair_number = $this->pair_numbers->getPairByNumber($pair_number_count);
        if ($pair_number) {
            return $pair_number;
        }

        throw new ScheduleManagerException('Последовательность пар не настроена');
    }

    /**
     * @return void
     * @throws ScheduleManagerException
     */
    private function initSearchData()
    {
        $data = request()->session()->get('schedule_manager_request');
        if (!$data) {
            throw new ScheduleManagerException('Не найдены данные для поиска');
        }
        $this->searchData = new ScheduleSearchData($data);
    }
}
