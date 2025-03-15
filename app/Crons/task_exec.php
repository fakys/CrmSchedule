<?php
use App\Src\crons\TaskManager;
use App\Src\crons\TaskSchedule;
use App\Src\redis\RedisManager;
use Illuminate\Foundation\Configuration\ApplicationBuilder;

// Импортируем composer autoload
require __DIR__ . '/../../vendor/autoload.php';

/**
 * @var $app ApplicationBuilder
 */
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();


var_dump(date('Y-m-d H:i:s'));

$schedule = new TaskSchedule();
$task = $schedule->getScheduleTask();

if ($task) {
    try {
        /** Запускаем таск */
        if (TaskManager::getFullTasks()->runTask($task->task_name)){
            \App\Src\BackendHelper::getRepositories()->updateTaskScheduleStatus($task, TaskSchedule::DONE_STATUS, date("Y-m-d H:i:s"));
        }
        var_dump(1);
    } catch (Exception $exp) {
        var_dump($exp->getMessage()." ".$exp->getTraceAsString());
    }
}

