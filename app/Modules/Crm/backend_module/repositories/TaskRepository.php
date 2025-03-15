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
        $task->end_time = $data['time_end'];
        $task->pid = $data['pid'];
        if ($task->save()) {
            return $task;
        }
    }

    /**
     * Обновляет статус таску и ставит время окончания
     * @param ScheduleTask $task
     * @param $status
     * @param null $time_end
     * @return mixed
     */
    public function updateTaskScheduleStatus($task, $status, $time_end = null)
    {
        $task->status = $status;
        $task->end_time = $time_end;
        return $task->save();
    }

}
