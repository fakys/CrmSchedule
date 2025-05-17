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
$laravel_kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$laravel_kernel->bootstrap();

// Инициализация ядра
require __DIR__.'/../Src/modules/kernel/init_kernel.php';


var_dump(date('Y-m-d H:i:s'));


