<?php

use App\Src\crons\TaskSchedule;
use App\Src\redis\RedisManager;
use App\Src\Context;
use Illuminate\Http\Request;

// Импортируем composer autoload
require __DIR__ . '/../vendor/autoload.php';

//// Determine if the application is in maintenance mode...
//if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
//    require $maintenance;
//}
//// Bootstrap Laravel and handle the request...
//(require_once __DIR__.'/../bootstrap/app.php')
//    ->handleRequest(Request::capture());

$redis = new RedisManager();
//RedisManager::redis();
//if ($redis->ping()) {
//    $schedule = new TaskSchedule($redis->get('task_schedule'));
//    $schedule->startTasks();
//}

var_dump(12312312);
