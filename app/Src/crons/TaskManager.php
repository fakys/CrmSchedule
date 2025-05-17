<?php

namespace App\Src\crons;

use App\Src\BackendHelper;
use App\Src\modules\task\AbstractTask;
use App\Src\traits\TraitObjects;

class TaskManager{
    use TraitObjects;

    protected $tasks;
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @param $task_name
     * @param $args
     * @return bool
     */
    public function runTask($task_name, $args)
    {
        $task = BackendHelper::getTaskByName($task_name);

        if ($args && json_decode($args, 1)) {
            return $task->Execute(json_decode($args, 1));
        } else {
            return $task->Execute([]);
        }
    }


    /**
     * @param $task_name
     * @return AbstractTask
     */
    public function getTaskByName($task_name)
    {
        foreach ($this->tasks as $task) {
            if ($task::taskName() == $task_name) {
                return new $task();
            }
        }
        return null;
    }

    /**
     * @return $this
     */
    public static function getFullTasks()
    {
        $modules = BackendHelper::getFullModule();
        $arr_tasks = [];
        foreach ($modules as $module) {
            $arr_tasks = array_merge($arr_tasks, $module::tasks());
        }
        return self::objects($arr_tasks);
    }
}
