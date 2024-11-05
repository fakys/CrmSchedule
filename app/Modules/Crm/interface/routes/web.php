<?php

use App\Modules\Crm\interface\InfoModule;
use Illuminate\Support\Facades\Route;

Route::get('/', [
    \App\Modules\Crm\interface\controllers\InterfaceController::class , 'actionIndex'
])->name('interface.index');
