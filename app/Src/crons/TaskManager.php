<?php

namespace App\Src\crons;

use App\Src\BackendHelper;
use App\Src\traits\TraitObjects;

class TaskContext{
    use TraitObjects;

    protected $tasks;
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }


    /**
     * @param $task_name
     * @return mixed|null
     */
    public function getTaskByName($task_name)
    {
        foreach ($this->tasks as $task) {
            if ($task::taskName == $task_name) {
                return $task;
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
