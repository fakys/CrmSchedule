<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(1);
    return 3213213;
});

//\App\Src\routes\ModuleRoute::route([
//    'route'=>Route::class,
//    'config'=>config('modules'),
//    'main_module'=>'Crm'
//]);
