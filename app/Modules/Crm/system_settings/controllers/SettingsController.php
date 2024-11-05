<?php
namespace App\Modules\Crm\system_settings\controllers;

use App\Modules\Crm\system_settings\InfoModule;

class SettingsController{

    public function __construct()
    {
        (new InfoModule())->runConfig();
    }
    public function actionSystemSettings()
    {
        $allTimezones = [
            'Europe/Kaliningrad' => '+2',
            'Europe/Moscow' => '+3',
            'Europe/Samara' => '+4',
            'Asia/Yekaterinburg' => '+5',
            'Asia/Omsk' => '+6',
            'Asia/Krasnoyarsk' => '+7',
            'Asia/Irkutsk' => '+8',
            'Asia/Yakutsk' => '+9',
            'Asia/Vladivostok' => '+10',
            'Asia/Magadan'=> '+11',
            'Asia/Kamchatka' => '+12',
        ];
        $systemName = config('app.name');
        $systemLang = [
            'ru'=>'Русский',
            'en'=>'English'
        ];
        return view('settings.system_settings', compact('allTimezones', 'systemName', 'systemLang'));
    }
}
