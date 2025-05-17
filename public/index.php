<?php

use App\Src\BackendHelper;
use App\Src\Context;
use Illuminate\Http\Request;

// Импортируем composer autoload
require __DIR__.'/../vendor/autoload.php';




define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
$app = require_once __DIR__.'/../bootstrap/app.php';

// Инициализация Laravel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Инициализация ядра CRM
require __DIR__.'/../app/Src/modules/kernel/init_kernel.php';
//создаем контекст
/**
 * @return Context
 */
function context()
{
    return Context::GetContext(Request::capture());
}

($app)->handleRequest(Request::capture());
