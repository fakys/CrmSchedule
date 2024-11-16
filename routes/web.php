<?php

use Illuminate\Support\Facades\Route;

Route::middleware(\App\Middleware\ModulesMiddleware::class)->group(function () {
    \App\Src\routes\ModuleRoute::route([
        'route'=>Route::class,
        'config'=>config('modules'),
        'main_module'=>'Crm'
    ]);
});
