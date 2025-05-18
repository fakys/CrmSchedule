<?php

namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;
use App\Modules\Crm\schedule\src\entity\ScheduleSearchData;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PairNumberEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\PlanScheduleEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\SemesterEntity;
use App\Modules\Crm\schedule\src\schedule_manager\entity\units\SemesterUnit;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\modules\plugins\AbstractPlugin;
use App\Src\redis\RedisManager;

/**
 * Создает базовое расписание
 * @property ScheduleSearchData $searchData
 * @property Schedule $schedule
 * @property SemesterEntity $semesters
 * @property PairNumberEntity $pair_numbers
 * @property PlanScheduleEntity[] $planScheduleRepository
 * @property RedisManager $redis
 * @property array cash_schedule
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
        $settings = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName());
        $base_schedule = [];

        if ($settings->cash_schedule) {
            $this->redis = new RedisManager();
            if (!$this->redis->redis->get('schedule')) { //Если в кеше ничего нет, кешируем
                BackendHelper::getOperations()->cashSchedule();
            }
            $this->cash_schedule = json_decode($this->redis->redis->get('schedule'), 1);
            if ($this->searchData->getGroupsId()) {
                foreach ($this->searchData->getGroupsId() as $group) {
                    $base_schedule[$group] = $this->getCashSchedule($group);
                }
            } elseif ($this->searchData->getSpecialtiesId()) {
                foreach ($this->searchData->getSpecialtiesId() as $specialty) {
                    $specialty_obj = BackendHelper::getRepositories()->getSpecialtyById($specialty);
                    $groups = $specialty_obj->getGroups();
                    foreach ($groups as $group) {
                        foreach ($this->semesters->getSemesters() as $semester) {
                            $base_schedule[$group->id][] = $this->cash_schedule[$group->id][$semester['id']];
                        }
                    }
                }
            } else {
                $groups = BackendHelper::getRepositories()->getFullStudentGroups();
                if ($groups) {
                    foreach ($groups as $group) {
                        foreach ($this->semesters->getSemesters() as $semester) {
                            $base_schedule[$group][] = $this->cash_schedule[$group][$semester['id']];
                        }
                    }
                }
            }
        }

        /** Получаем данные из репозитория */
        if (!$base_schedule) {
            if ($this->searchData->getGroupsId()) {
                foreach ($this->searchData->getGroupsId() as $group) {
                    $base_schedule[$group] = BackendHelper::getRepositories()
                        ->getScheduleUnitsByDate($this->searchData->getDateStart(), $this->searchData->getDateEnd(), $group);
                }
            } elseif ($this->searchData->getSpecialtiesId()) {
                foreach ($this->searchData->getSpecialtiesId() as $specialty) {
                    $specialty_obj = BackendHelper::getRepositories()->getSpecialtyById($specialty);
                    $groups = $specialty_obj->getGroups();
                    foreach ($groups as $group) {
                        $base_schedule[$group->id] = BackendHelper::getRepositories()
                            ->getScheduleUnitsByDate($this->searchData->getDateStart(), $this->searchData->getDateEnd(), $group->id);
                    }
                }
            } else {
                $groups = BackendHelper::getRepositories()->getFullStudentGroups();
                if ($groups) {
                    foreach ($groups as $group) {
                        $base_schedule[$group->id] = BackendHelper::getRepositories()
                            ->getScheduleUnitsByDate($this->searchData->getDateStart(), $this->searchData->getDateEnd(), $group->id);
                    }
                }
            }
        }

        foreach ($base_schedule as $group_id => $units_group) {
            foreach ($units_group as $unit) {
                if (!$this->semesters->getUnitByGroup($unit->group_id, $unit->semester_id)) {
                    $this->semesters->loanSemestersUnit($this->semesters->getSemesterByDate(new \DateTime($unit->date)), $group_id);
                }
                $this->addSchedule($unit);
            }
        }
        $this->setResult($this->schedule);
        return $this->schedule;
    }

    /**
     * Добавляет расписание
     * @param \DateTime $date
     */
    public function addSchedule($unit)
    {
        $schedule_unit = new ScheduleUnit();
        $schedule_unit->setDate(new \DateTime($unit->date));
        $schedule_unit->setPairNumber($unit->pair_number);
        $schedule_unit->setGroup($unit->group_id);
        $schedule_unit->setTimeStart($unit->schedule_time_start);
        $schedule_unit->setTimeEnd($unit->schedule_time_end);
        $schedule_unit->setSubject($unit->subject_id);
        $schedule_unit->setUser($unit->teacher_id);
        $schedule_unit->setFormatPair($unit->format_lesson_id);
        $schedule_unit->setDescription($unit->schedule_description);
        $schedule_unit->setSemester($unit->semester_id);
        $schedule_unit->setSemesterName($unit->semester_name);
        if ($unit->schedule_week_day && $unit->schedule_week_number) {
            $schedule_unit->setWeekNumber($unit->schedule_week_number);
            $schedule_unit->setWeekDay($unit->schedule_week_day);
        } else {
            $schedule_unit->setWeekNumber(
                $this->getNumberWeekBySemester(new \DateTime($unit->date), $this->semesters->getUnitByGroup(
                    $unit->group_id,
                    $unit->semester_id
                ))
            );
            $schedule_unit->setWeekDay((new \DateTime($unit->date))->format('w'));
        }
        $this->schedule->addUnit($schedule_unit);
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
     * @return void
     * @throws ScheduleManagerException
     */
    private function initSearchData()
    {
        if ($this->context->getAttr('search_data')) {
            $data = $this->context->getAttr('search_data');
        } else {
            $data = request()->session()->get('schedule_manager_request');
        }

        if (!$data) {
            throw new ScheduleManagerException('Не найдены данные для поиска');
        }
        $this->searchData = new ScheduleSearchData($data);
    }

    /**
     * @param \DateTime $date
     * @param SemesterUnit $semester_unit
     * @return int
     */
    public function getNumberWeekBySemester($date, $semester_unit)
    {
        return BackendHelper::getOperations()->getCurrentWeek(
            $date, $semester_unit->getDateStart(),
            empty($semester_unit->getTypePlanParam()['weeks']) ? 1 : count($semester_unit->getTypePlanParam()['weeks']));
    }

    private function getCashSchedule($group)
    {
        $schedule_base_data = [];
        foreach ($this->semesters->getSemesters() as $semester) {
            foreach ($this->cash_schedule[$group][$semester['id']] as $schedule_unit_data) {
                if (
                    $this->searchData->getDateStart() <= new \DateTime($schedule_unit_data['date']) &&
                    new \DateTime($schedule_unit_data['date']) <= $this->searchData->getDateEnd()
                ) {
                    $schedule_base_data[] = (object)$schedule_unit_data;
                }
            }
        }
        return $schedule_base_data;
    }
}
