<?php

use App\Modules\RestApi\schedule_api\models\ReturnArray;
use App\Src\BackendHelper;
use App\Src\Context;
use App\Src\crons\TaskManager;
use App\Src\crons\TaskSchedule;
use App\Src\modules\kernel\constructs\ConstructComponents;
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


dd(BackendHelper::getKernel()->getControllerLoader());
