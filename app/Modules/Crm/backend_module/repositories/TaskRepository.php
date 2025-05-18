<?php
namespace App\Modules\Crm\backend_module\repositories;


use App\Entity\ScheduleTask;
use App\Src\modules\repository\AbstractRepositories;
use Illuminate\Support\Facades\DB;

;

class TaskRepository extends AbstractRepositories{

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

    /**
     * роверяет есть ли у пользователя активные таски
     * @param $task_name
     * @param $user_name
     * @return array
     */
    public function hasActiveTaskByUserName($task_name, $user_name)
    {
        $sql = "select * from schedule_task
         where task_name = :task_name and args->>'userName'= '$user_name' and status in (:status_active, :status_pending)";

        return DB::select(
            $sql,
            [
                'task_name' => $task_name,  'status_active' => ScheduleTask::ACTIVE_STATUS,
                'status_pending' => ScheduleTask::PENDING_STATUS
            ]
        );
    }

    /**
     * проверяет есть ли активные таски
     * @param $task_name
     * @return array
     */
    public function hasActiveTask($task_name)
    {
        return ScheduleTask::where(
            ['task_name' => $task_name, 'status' => [ScheduleTask::ACTIVE_STATUS, ScheduleTask::PENDING_STATUS]]
        )->first();
    }

    public function getName(): string
    {
        return 'task_repository';
    }
}
