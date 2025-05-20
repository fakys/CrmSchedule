<?php

use App\Middleware\AccessMiddleware;
use App\Middleware\ModulesMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([ModulesMiddleware::class, AccessMiddleware::class])->group(function () {
    \App\Src\routes\ModuleRoute::route([
        'route'=>Route::class,
        'config'=>config('modules')
    ], 'Crm');
});
