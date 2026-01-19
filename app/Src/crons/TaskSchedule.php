<?php

namespace App\Src\crons;

use App\Entity\ScheduleTask;
use App\Src\BackendHelper;
use App\Src\rabbit\RabbitMQ;
use App\Src\redis\RedisManager;
use App\Src\traits\TraitObjects;

class TaskSchedule
{
    use TraitObjects;

    const QUEUE = 'task_queue';
    const ACTIVE_STATUS = 'active';
    const PENDING_STATUS = 'pending';
    const DONE_STATUS = 'done';

    private $rabbit;

    public function __construct()
    {
        $this->rabbit = new RabbitMQ(self::QUEUE);
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
        $this->schedulePush($task_data);
    }


    /**
     * @param $task
     * @return void
     * @throws \RedisException
     */
    private function schedulePush($task)
    {
        $this->rabbit->appendQueue($task);
    }

    /**
     * @return \App\Entity\ScheduleTask|null
     * @throws \RedisException
     */
    public function getScheduleTask()
    {
        $task = $this->rabbit->getQueue();
        if ($task) {
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
