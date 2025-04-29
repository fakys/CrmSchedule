<?php

use App\Src\Context;
use App\Src\crons\TaskManager;
use App\Src\crons\TaskSchedule;
use App\Src\redis\RedisManager;
use Illuminate\Foundation\Configuration\ApplicationBuilder;
use Illuminate\Http\Request;


// Импортируем composer autoload
require __DIR__ . '/../vendor/autoload.php';

/**
 * @var $app ApplicationBuilder
 */
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
//
//$redis = RedisManager::redis();
//var_dump($redis->get('cron_schedule_task'));


//\App\Src\BackendHelper::taskCreate('test_task', []);
//$schedule = new TaskSchedule();
//$task = $schedule->getScheduleTask();
////
////var_dump($task);
//TaskManager::getFullTasks()->runTask('report_for_group_task', '[1,2,3]');
var_dump(\App\Src\BackendHelper::getTaskByName('test_task')->Execute());
