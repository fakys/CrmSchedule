<?php
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Modules\Crm\interface\controllers\InterfaceController::class , 'actionIndex']);
