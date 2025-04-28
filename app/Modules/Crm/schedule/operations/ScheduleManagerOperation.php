<?php

namespace App\Modules\Crm\schedule\operations;

use App\Entity\Lesson;
use App\Entity\Schedule;
use App\Modules\Crm\schedule\src\EditNewScheduleData;
use App\Modules\Crm\schedule\src\entity\ScheduleUnit;
use App\Modules\Crm\schedule\src\ScheduleManager;
use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use Illuminate\Support\Facades\DB;

class ScheduleManagerOperation extends AbstractOperation
{
    /**
     * Возвращает расписание для менеджера расписаний
     * ОПЕРАЦИЯ УСТАРЕЛА!!!
     * ИСПОЛЬЗОВАТЬ schedule_manger
     * @return array
     */
    public function getScheduleData($data)
    {
        $period = BackendHelper::getOperations()->pacePeriod($data['period']);
        $groups = isset($data['groups']) ? $data['groups'] : [];
        $specialties = isset($data['specialties']) ? $data['specialties'] : [];
        $manager = new ScheduleManager($period, $groups, $specialties);
        return $manager->getSchedule();
    }

    /**
     * Редактирует расписание
     * @param $newSchedule
     * @param $searchData
     * @return bool
     *
     */
    public function editSchedule($newSchedule)
    {
        $newSchedule = new EditNewScheduleData($newSchedule);

        foreach ($newSchedule->getUnits() as $unit) {
            if (BackendHelper::getRepositories()
                ->getScheduleByDate($unit->getOldDate()->format('Y-m-d'), $unit->getOldGroup(), $unit->getOldPairNumber())
            ) {
                /** Создаем транзакцию на случай ошибки */
                DB::transaction(function () use ($unit) {
                    BackendHelper::getOperations()
                        ->saveSchedule($unit);
                });
            } else {
                /** Создаем транзакцию на случай ошибки */
                DB::transaction(function () use ($unit) {
                    BackendHelper::getOperations()
                        ->createSchedule($unit);
                });
            }

        }
        return true;
    }

    /**
     * Сохраняет новое расписание по старым данным
     * @param ScheduleUnit $unit
     * @return void
     */
    public function saveSchedule($unit)
    {
        $schedule_data = BackendHelper::getRepositories()->getScheduleByDate(
            $unit->getOldDate()->format('Y-m-d'),
            $unit->getOldGroup(),
            $unit->getOldPairNumber()
        )[0];

        /** @var Schedule $schedule Entity расписания */
        $schedule = BackendHelper::getRepositories()->getSchedulesById($schedule_data->id);
        $lessons = $schedule->getLesson();
        $duration = $schedule->getDuration();
        /** Дата начала */
        $schedule_date = new \DateTime($duration->date_start);

        /**
         * Если на дату нового расписания ничего не назначено, то изменяем его
         */
        $new_schedule_data = BackendHelper::getRepositories()->getScheduleByDate(
            $unit->getNewDate()->format('Y-m-d'),
            $unit->getNewGroup(),
            $unit->getNewPairNumber()
        );
        if (
            !$new_schedule_data ||
            $new_schedule_data &&
            $new_schedule_data[0]->id == $schedule_data->id
        ) {

            BackendHelper::getOperations()->checkScheduleData(
                $unit->getNewGroup(),
                $schedule->student_group_id,
                'student_group_id',
                $schedule
            );
            BackendHelper::getOperations()->checkScheduleData(
                $unit->getNewPairNumber(),
                $schedule->pair_number_id,
                'pair_number_id',
                $schedule
            );
            BackendHelper::getOperations()->checkScheduleData(
                $unit->getDescription(),
                $schedule->description,
                'description',
                $schedule
            );
            if ($lessons) {
                BackendHelper::getOperations()->checkScheduleData(
                    $unit->getSubject(),
                    $lessons->subject_id,
                    'subject_id',
                    $lessons
                );
                BackendHelper::getOperations()->checkScheduleData(
                    $unit->getUser(),
                    $lessons->user_id,
                    'user_id',
                    $lessons
                );
                BackendHelper::getOperations()->checkScheduleData(
                    $unit->getFormatPair(),
                    $lessons->format_lesson_id,
                    'format_lesson_id',
                    $lessons
                );
            }
            if ($duration) {
                BackendHelper::getOperations()->checkScheduleData(
                    $unit->getTimeStart(),
                    $duration->time_start,
                    'time_start',
                    $duration
                );
                BackendHelper::getOperations()->checkScheduleData(
                    $unit->getTimeEnd(),
                    $duration->time_end,
                    'time_end',
                    $duration
                );
                BackendHelper::getOperations()->checkScheduleData(
                    $unit->getNewDate()->format('Y-m-d'),
                    $schedule_date->format('Y-m-d'),
                    'date_start',
                    $duration
                );
            }
        }
    }

    /**
     * @param $new_data
     * @param $old_data
     * @param $entity
     * @return void
     */
    public function checkScheduleData($new_data, $old_data, $name_field, $entity)
    {
        if ($new_data != $old_data) {
            BackendHelper::getRepositories()->updateDataByEntity($new_data, $name_field, $entity);
        }
    }

    /**
     * Создает расписание
     * @param ScheduleUnit $unit
     * @return bool
     */
    public function createSchedule($unit)
    {
        $user_id = $unit->getUser() == 0 ? null : $unit->getUser();
        /** Создаем предмет */
        $lesson = BackendHelper::getRepositories()->createLessons($unit->getSubject(), $unit->getFormatPair(), $user_id);
        if (!$lesson) {
            throw new SchedulePlanAddException('Ошибка при создании предмета');
        }

        /** Длительность в минутах */
        $duration_minutes = (new \DateTime($unit->getTimeStart()))->diff(new \DateTime($unit->getTimeEnd()))->i;
        /** Создаем длительность предмета */
        $duration = BackendHelper::getRepositories()->createDurationLessons(
            $unit->getNewDate()->format('Y-m-d'),
            $unit->getTimeStart(),
            $unit->getTimeEnd(),
            $duration_minutes
        );
        if (!$duration) {
            throw new SchedulePlanAddException('Ошибка при создании длительности предмета');
        }

        $schedule = BackendHelper::getRepositories()->createSchedule(
            $duration->id,
            $unit->getNewPairNumber(),
            $unit->getNewGroup(),
            $lesson->id,
            $unit->getDescription()
        );

        if (!$schedule) {
            throw new SchedulePlanAddException('Ошибка при создании расписания');
        }

        return true;
    }

    public function getName(): string
    {
        return 'schedule_manager_operation';
    }
}
