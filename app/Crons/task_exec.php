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




$redis = RedisManager::redis();
$schedule = TaskSchedule::setSchedule($redis->get('task_schedule'), $redis);

$task_id = $argv[1];
$task_name = $argv[2];

try {
    if (TaskManager::getFullTasks()->runTask($task_name)){
        $schedule->updateStatusTask($task_id, TaskSchedule::DONE_STATUS);
    }
} catch (Exception $exp) {
    $schedule->setException($task_id, $exp);
    $schedule->updateStatusTask($task_id, TaskSchedule::DONE_STATUS);
}


file_put_contents('last_task.txt', print_r(sprintf('task_id = %s task_name = %s date = %s', $task_id, $task_name, date('Y-m-d H:i:s')), true));
