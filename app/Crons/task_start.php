<?php


use App\Src\BackendHelper;
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

try {
    do {
        $schedule = TaskSchedule::setSchedule($redis->get('task_schedule'), $redis);

        $schedule->startTasks();
        file_put_contents('last_task.txt', print_r($redis->get('task_schedule'), 1));
        sleep(30);

    }while (true);
} catch (Exception $exception) {
}









