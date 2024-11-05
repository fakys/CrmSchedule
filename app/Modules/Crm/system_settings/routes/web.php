<?php

use App\Modules\Crm\system_settings\InfoModule;
use Illuminate\Support\Facades\Route;

(new InfoModule)->runConfig();

Route::get('/settings/system-settings',
    [
        \App\Modules\Crm\system_settings\controllers\SettingsController::class,
        'actionSystemSettings'
    ])->name('system_settings.settings');
