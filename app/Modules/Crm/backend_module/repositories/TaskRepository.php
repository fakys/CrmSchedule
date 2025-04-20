<?php
namespace App\Modules\Crm\backend_module\repositories;


use App\Entity\ScheduleTask;
use App\Src\modules\repository\Repository;

class TaskRepository extends Repository{

    /**
     * Добавляет таск в БД
     * @param array $data массив с данными о таске
     * @return ScheduleTask|null
     */
    public function addTaskSchedule($data)
    {
        $task = new ScheduleTask();
        $task->task_name = $data['task_name'];
        $task->status = $data['status'];
        $task->start_time = $data['time_create'];
        $task->args = json_encode($data['args']);
        $task->end_time = $data['time_end'];
        $task->pid = $data['pid'];
        if ($task->save()) {
            return $task;
        }
    }

    /**
     * Возвращает таск по id
     * @param $id
     * @return mixed
     */
    public function getTaskScheduleById($id)
    {
        return ScheduleTask::where(['id'=>$id])->first();
    }

    /**
     * Обновляет статус таску и ставит время окончания
     * @param ScheduleTask $task
     * @param $status
     * @param null $time_end
     * @return ScheduleTask|null
     */
    public function updateTaskScheduleStatus($task, $status, $time_end = null)
    {
        $task->status = $status;
        $task->end_time = $time_end;
        if ($task->save()) {
            return $task;
        }
    }

    /**
     * Обновляет таск по id
     * @param $id
     * @param $task
     * @return ScheduleTask|void
     */
    public function updateTaskScheduleById($id, $task)
    {
        /** @var ScheduleTask $schedule */
        $schedule = ScheduleTask::where(['id'=>$id])->first();
        if ($schedule) {
            $schedule->status = $task['status'];
            $schedule->pid = $task['pid'];
        }
        if ($schedule->save()) {
            return $schedule;
        }
    }

}
