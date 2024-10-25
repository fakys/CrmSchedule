<?php

use Illuminate\Support\Facades\Route;


\App\Src\routes\ModuleRoute::route([
    'route'=>Route::class,
    'config'=>config('modules'),
    'main_module'=>'Crm'
]);
