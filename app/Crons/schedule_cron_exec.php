<?php

use App\Src\crons\CronSchedule;
use App\Src\crons\TaskManager;
use App\Src\crons\TaskSchedule;
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

$schedule = new CronSchedule();
$cron = $schedule->getScheduleCron();

if ($cron) {
    try {
        /** Запускаем крон */
        if (get_components_by_name($cron->cron_name)->getComponent()->Execute()){
            \App\Src\BackendHelper::getRepositories()
                ->updateStatusCronSchedule($cron->id, TaskSchedule::DONE_STATUS, date("Y-m-d H:i:s"));
        }
    } catch (Exception $exp) {
        var_dump($exp->getMessage()." ".$exp->getTraceAsString());
    }
}
