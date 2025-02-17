<?php

namespace App\Src\crons;

use App\Src\redis\RedisManager;
use App\Src\traits\TraitObjects;

class TaskSchedule
{
    use TraitObjects;

    const ACTIVE_STATUS = 'active';
    const PENDING_STATUS = 'pending';
    const DONE_STATUS = 'done';

    protected $schedule;
    protected $task_manager;
    protected $redis;

    public function __construct($schedule = [], $redis = [])
    {
        $this->redis = $redis ? $redis : $this->getRedis();
        $this->scheduleEncode($schedule);
        $this->task_manager = TaskManager::getFullTasks();
    }

    private function getRedis()
    {
        return RedisManager::redis();
    }

    private function scheduleEncode($schedule)
    {
        if ($schedule) {
            $schedule = json_decode($schedule, 1);
        } else {
            if ($this->redis->get('task_schedule')) {
                $schedule = json_decode($this->redis->get('task_schedule'), 1);
            } else {
                $schedule = [];
                $this->redis->set('task_schedule', []);
            }

        }
        $this->schedule = $schedule;
    }

    /**
     * Создает таск
     * @param $task_name
     * @param $args
     * @return bool
     */
    public function taskCreate($task_name, $args = [])
    {
        if (json_encode($args)) {
            $this->schedule[] = [
                'id' => uniqid(),
                'task_name' => $task_name,
                'args' => json_encode($args),
                'create_date' => (new \DateTime())->format('Y-m-d H:i:s'),
                'end_date' => null,
                'status' => self::ACTIVE_STATUS,
                'exception' => null,
                'pid' => getmypid()
                ];
            $this->updateRedisSchedule();
            return true;
        }
        return false;
    }

    /**
     * @param $redis
     * @return void
     */
    public function setScheduleInRedis()
    {
        $this->redis->set('task_schedule', $this->getScheduleJson());
    }


    /**
     * @param false|array $schedule
     * @return $this
     */
    public static function setSchedule($schedule, $redis)
    {
        return new self ($schedule, $redis);
    }

    /**
     * Возвращает расписание
     * @return array
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Возвращает расписание в json
     * @return string
     */
    public function getScheduleJson()
    {
        return json_encode($this->schedule);
    }

    public function updateSchedule()
    {
        $this->scheduleEncode($this->redis->get('task_schedule'));
    }

    public function startTasks()
    {
        foreach ($this->schedule as $schedule) {
            if (
                $schedule && isset($schedule['task_name']) &&
                isset($schedule['status']) &&
                $schedule['status'] == self::ACTIVE_STATUS
            ) {

                $task_id = $schedule['id'];
                $task_name = $schedule['task_name'];
                $schedule['status'] = self::PENDING_STATUS;
                $command = sprintf("php task_exec.php %s %s &", $task_id, $task_name);
                $output = [];
                $returnCode = 0;
                $this->clearTasks();
                $this->updateStatusTask($task_id, self::PENDING_STATUS);
                $this->updateSchedule();

                exec($command, $output, $returnCode);
            }
        }
    }


    /**
     * Обновляет очередь Редиса
     * @return void
     */
    public function updateRedisSchedule()
    {
        $this->redis->set('task_schedule', $this->getScheduleJson());
    }

    /**
     * Чистит очередь
     * @return true
     */
    protected function clearTasks()
    {
        foreach ($this->schedule as $num=>$task) {
            $delay_date = (new \DateTime())->modify('+ 1 hour');
            if (new \DateTime($task['end_date']) >= $delay_date) {
                unset($this->schedule[$num]);
            }
        }
        return true;
    }


    /**
     * Выставляет таску статус
     * @param $id
     * @return bool
     */
    public function updateStatusTask($id, $status)
    {
        foreach ($this->schedule as $num=>$task) {
            try {
                if ($task && $task['id'] == $id) {
                    $task['status'] = $status;
                    $this->schedule[$num] = $task;

                    if ($status == self::DONE_STATUS) {
                        $task['end_date'] = (new \DateTime())->format('Y-m-d H:i:s');
                    }

                    $this->updateRedisSchedule();
                    return true;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        return false;
    }

    public function deleteTaskById($id)
    {
        foreach ($this->schedule as $num=>$task) {
            try {
                if ($task && $task['id'] == $id) {
                    unset($this->schedule[$num]);
                    $this->updateRedisSchedule();
                    return true;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        return false;
    }

    /**
     * Сохраняем ошибки по таску
     * @param $id
     * @param $exp
     * @return bool
     */
    public function setException($id, $exp)
    {
        foreach ($this->schedule as $num=>$task) {
            try {
                if ($task && $task['id'] == $id) {
                    $this->schedule[$num]['exception'] = $exp;
                    $this->updateRedisSchedule();
                    return true;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        return false;
    }

    public function deleteFullTasks()
    {
     $this->schedule = [];
     $this->updateRedisSchedule();
    }
}
