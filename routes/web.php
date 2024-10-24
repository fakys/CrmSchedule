<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 3213213;
});

\App\Src\routes\ModuleRoute::route([
    'route'=>Route::class,
    'config'=>config('modules'),
    'main_module'=>'Crm'
]);
