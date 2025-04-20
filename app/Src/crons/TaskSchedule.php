<?php

namespace App\Src\crons;

use App\Entity\ScheduleTask;
use App\Src\BackendHelper;
use App\Src\redis\RedisManager;
use App\Src\traits\TraitObjects;

class TaskSchedule
{
    use TraitObjects;

    const ACTIVE_STATUS = 'active';
    const PENDING_STATUS = 'pending';
    const DONE_STATUS = 'done';

    private $redis;

    public function __construct()
    {
        $this->redis = RedisManager::redis();
    }

    /**
     * Создает таск и добавляет его в очередь
     * @param string $task_name Название таска
     * @param array $task_args Аргументы таска
     * @return void
     */
    public function taskCreate($task_name, $task_args = [])
    {

        $task_data = [
            'task_name' => $task_name,
            'args' => $task_args,
            'status' => self::ACTIVE_STATUS, //Статус таска
            'time_create' => date('Y-m-d H:i:s'), //Время его создания
            'time_end' => null, //Время когда он выполнился
            'pid' => null //Номер процесса
        ];

        $task = BackendHelper::getRepositories()->addTaskSchedule($task_data);

        $task_data['id'] = $task->id;
        /** Заполняем очередь */
        $this->schedulePush(json_encode($task_data));
    }


    /**
     * @param $json_task
     * @return void
     * @throws \RedisException
     */
    private function schedulePush($json_task)
    {
        $this->redis->rPush('cron_schedule_task', $json_task);
    }

    /**
     * @return \App\Entity\ScheduleTask|null
     * @throws \RedisException
     */
    public function getScheduleTask()
    {
        $task_json = $this->redis->rPop('cron_schedule_task');
        if ($task_json) {
            $task = json_decode($task_json, true);
            if ($task['status'] === self::ACTIVE_STATUS) {
                $task['status'] = self::PENDING_STATUS;
                $task['pid'] = getmypid();
                $task_schedule = BackendHelper::getRepositories()->getTaskScheduleById($task['id']);
                if ($task_schedule) {
                    return BackendHelper::getRepositories()->updateTaskScheduleById($task_schedule->id, $task);
                }
                return BackendHelper::getRepositories()->addTaskSchedule($task);
            }
        }
    }
}
