<?php

use App\Modules\Crm\interface\InfoModule;
use Illuminate\Support\Facades\Route;

Route::get('/', [
    \App\Modules\Crm\interface\controllers\InterfaceController::class , 'actionIndex'
])->name('interface.index');

Route::get('/interface/users', [
    \App\Modules\Crm\interface\controllers\UsersInterfaceController::class , 'actionUsers'
])->name('interface.users');
