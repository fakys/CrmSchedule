<?php
namespace App\Modules\Crm\system_settings\controllers;

use App\Modules\Crm\system_settings\models\CrmSetting;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Modules\Crm\system_settings\models\SystemSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
class SettingsController extends AbstractController {

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmLink('system_settings')
            ->setText('Настройки системы')
            ->setIcon('fa fa-cog')
            ->setLink(route('system_settings.crm_settings'));
    }


    /**
     * Страница настроек CRM
     * @return mixed
     */
    public function actionCRMSettings()
    {
        $setting = BackendHelper::getSystemSettings(CrmSetting::getSettingName());
        $systemName = config('app.name');

        if($setting->system_name){
            $systemName = $setting->system_name;
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
        return view('system_settings::settings.crm_settings',
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
                ['name'=>CrmSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>context()->getUser()->id, 'active'=>true]
            );
        }
        return redirect()->route('system_settings.crm_settings');
    }

    /**
     * Страница системных настроек
     * @return mixed
     */
    public function actionSystemSettings()
    {
        $groups = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        $users = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllActiveUsers(), 'username', 'id');
        $settings = BackendHelper::getSystemSettings(SystemSetting::getSettingName());
        $settings_group = ArrayHelper::arrayInt($settings->system_user_groups);
        $settings_users = ArrayHelper::arrayInt($settings->system_users);
        return view('system_settings::settings.system_settings', ['groups'=>$groups, 'users'=>$users, 'settings_group'=>$settings_group, 'settings_users'=>$settings_users]);
    }

    public function setSystemSettings()
    {
        $model = new SystemSetting();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate() || (!$validate->validate() && !$model->getData())){
            $settings = json_encode($model->getData());
            BackendHelper::getOperations()->createSystemSettings(
                ['name'=>SystemSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>context()->getUser()->id, 'active'=>true]
            );
        }
        return redirect()->route('system_settings.settings');
    }

    public function actionScheduleSettings()
    {
        $settings = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName());
        $users_groups_settings = $settings->users_groups;
        $users_groups = BackendHelper::getRepositories()->getAllUsersGroup();
        $type_weeks = [1 => 'Шестидневка', 2 => 'Пятидневка'];
        return view('system_settings::settings.schedule_settings', [
            'users_groups'=>$users_groups,
            'users_groups_settings'=>$users_groups_settings,
            'type_weeks'=>$type_weeks,
            'settings'=>$settings
        ]);
    }

    public function setScheduleSettings()
    {
        $model = new ScheduleSetting();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate() || (!$validate->validate() && !$model->getData())){
            $settings = json_encode($model->getData());
            BackendHelper::getOperations()->createSystemSettings(
                ['name'=>ScheduleSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>context()->getUser()->id, 'active'=>true]
            );
        }
        return redirect()->route('system_settings.schedule_settings');
    }
}
