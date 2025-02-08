<?php

use App\Src\Context;
use App\Src\crons\TaskSchedule;
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


\App\Src\BackendHelper::taskCreate('test_task', []);
