<?php
namespace App\Modules\Crm\system_settings\controllers;

use App\Modules\Crm\system_settings\models\CrmSetting;
use App\Modules\Crm\system_settings\models\SystemSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
class SettingsController extends Controller{

    public function actionCRMSettings()
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
        return view('settings.crm_settings',
            compact('title', 'allTimezones', 'systemName', 'systemLang', 'setting'));
    }

    public function setCrmSettings()
    {
        $model = new CrmSetting();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if(request()->post() && $validate->validate()){
            $settings = json_encode($model->getData());
            BackendHelper::getOperations()->createSystemSettings(
                ['name'=>SystemSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>1, 'active'=>true]
            );
        }
        return redirect()->route('system_settings.crm_settings');
    }

    public function actionSystemSettings()
    {
        $groups = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        $users = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllActiveUsers(), 'username', 'id');
        return view('settings.system_settings', ['groups'=>$groups, 'users'=>$users]);
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
