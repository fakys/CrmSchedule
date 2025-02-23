<?php
namespace App\Modules\Crm\schedule\operations;

use App\Modules\Crm\schedule\src\ScheduleManager;
use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class ScheduleManagerOperation extends Operation
{
    /**
     * Возвращает расписание для менеджера расписаний
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
     * @return bool
     *
     */
    public function editSchedule($newSchedule, $searchData)
    {
        $period = BackendHelper::getOperations()->pacePeriod($searchData['period']);
        $data = [];

        /** Получаем данные из БД */
        foreach ($searchData['groups'] as $group) {
            $data[$group] = BackendHelper::getRepositories()->getScheduleByGroupFroManager(
                $period[0],
                $period[1],
                $group,
            );
        }


        foreach ($newSchedule as $schedule_old_group => $schedule_group) {
            foreach ($schedule_group as $schedule_old_date=>$new_schedule_pairs) {
                foreach ($new_schedule_pairs as $pair_number => $schedule_new) {

                    if (isset($data[$schedule_old_group])) {
                        BackendHelper::getOperations()
                            ->saveSchedule($schedule_new['schedule'], $pair_number, $schedule_old_group, $schedule_old_date, $data[$schedule_old_group]);
                    } else {

                    }


                }
            }
        }
        return true;
    }

    /**
     * Сохраняет новое расписание по старым данным
     * @param $new_schedule
     * @param $old_pair_number
     * @param $old_group_id
     * @param $old_date
     * @param $data_report
     * @return void
     */
    public function saveSchedule($new_schedule, $old_pair_number, $old_group_id, $old_date, $data_report)
    {
        if ($new_schedule) {
            foreach ($data_report as $schedule_data) {
                $schedule_date = new \DateTime($schedule_data->date_start);
                $old_schedule_date = new \DateTime($old_date);
                $new_schedule_date = new \DateTime($new_schedule['date_start']);
                $schedule = BackendHelper::getRepositories()->getSchedulesById($schedule_data->id);
                $lessons = $schedule->getLesson();
                $duration = $schedule->getDuration();

                /** Если это не новое расписание а изменение старого, то удаляем старое расписание */
                if (
                    $schedule_date->format('Y-m-d') == $old_schedule_date->format('Y-m-d') &&
                    $old_pair_number == $schedule_data->pair_number &&
                    $old_group_id == $schedule_data->group_id
                ) {
                    if ($schedule) {
//                        $schedule->delete();
                    }
                }

                /**
                 * Если новое расписание пересекается со старым, то изменяем его
                 * или если на данную дату нет расписания
                 */
                if (
                    $schedule_date->format('Y-m-d') == $new_schedule_date->format('Y-m-d') &&
                    $new_schedule['pair_number'] == $schedule_data->pair_number &&
                    $new_schedule['group_id'] == $schedule_data->group_id ||
                    !BackendHelper::getRepositories()
                        ->getScheduleByDate($new_schedule_date->format('Y-m-d'), $new_schedule['group_id'], $new_schedule['pair_number'])
                ) {

                    BackendHelper::getOperations()->checkScheduleData(
                        $new_schedule['group_id'],
                        $schedule_data->group_id,
                        'student_group_id',
                        $schedule
                    );

                    BackendHelper::getOperations()->checkScheduleData(
                        $new_schedule['pair_number'],
                        $schedule_data->pair_id,
                        'pair_number_id',
                        $schedule
                    );
                    BackendHelper::getOperations()->checkScheduleData(
                        $new_schedule['schedule_description'],
                        $schedule_data->schedule_description,
                        'description',
                        $schedule
                    );


                    if ($lessons) {
                        BackendHelper::getOperations()->checkScheduleData(
                            $new_schedule['subject_id'],
                            $schedule_data->subject_id,
                            'subject_id',
                            $lessons
                        );
                        BackendHelper::getOperations()->checkScheduleData(
                            $new_schedule['user_id'],
                            $schedule_data->teacher_id,
                            'user_id',
                            $lessons
                        );
                        BackendHelper::getOperations()->checkScheduleData(
                            $new_schedule['format_lesson_id'],
                            $schedule_data->format_id,
                            'format_lesson_id',
                            $lessons
                        );
                    } else {

                    }

                    if ($duration) {
                        BackendHelper::getOperations()->checkScheduleData(
                            $new_schedule['time_start'],
                            $schedule_data->time_start,
                            'time_start',
                            $duration
                        );
                        BackendHelper::getOperations()->checkScheduleData(
                            $new_schedule['time_end'],
                            $schedule_data->time_end,
                            'time_end',
                            $duration
                        );
                        BackendHelper::getOperations()->checkScheduleData(
                            $new_schedule_date->format('Y-m-d'),
                            $schedule_date->format('Y-m-d'),
                            'date_start',
                            $duration
                        );
                    }


                }
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

}
