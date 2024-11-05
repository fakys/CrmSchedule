<?php
namespace App\Modules\Crm\system_settings\controllers;

use App\Modules\Crm\system_settings\InfoModule;
use App\Modules\Crm\system_settings\models\SystemSetting;
use App\Src\BackendHelper;
use Illuminate\Support\Facades\Validator;

class SettingsController{

    public function __construct()
    {
        (new InfoModule())->runConfig();
    }
    public function actionSystemSettings()
    {
        $setting = BackendHelper::getOperations()->getСurrentSystemSettings();
        $systemName = config('app.name');
        if($setting){
            $setting = json_decode($setting->toArray()['settings']);

            if($setting->system_name){
                $systemName = $setting->system_name;
            }
        }
        $title = 'Настройки системы';
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

        $systemLang = [
            'ru'=>'Русский',
            'en'=>'English'
        ];
        return view('settings.system_settings',
            compact('title', 'allTimezones', 'systemName', 'systemLang', 'setting'));
    }

    public function setSystemSettings()
    {
        $model = new SystemSetting();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if(request()->post() && $validate->validate()){
            $settings = json_encode($model->getData());
            BackendHelper::getOperations()->createSystemSettings(
                ['name'=>SystemSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>1, 'active'=>true]
            );
        }
        return redirect()->route('system_settings.settings');
    }
}
