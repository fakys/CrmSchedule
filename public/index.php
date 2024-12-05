<?php

use App\Src\Context;
use Illuminate\Http\Request;

// Импортируем composer autoload
require __DIR__.'/../vendor/autoload.php';




define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
//создаем контекст
/**
 * @return Context
 */
function context()
{
    return Context::GetContext(Request::capture());
}

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
