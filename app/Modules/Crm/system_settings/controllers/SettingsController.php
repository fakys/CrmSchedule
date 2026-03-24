<?php
namespace App\Modules\Crm\system_settings\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\system_settings\assets\ScheduleSettingsBundle;
use App\Modules\Crm\system_settings\models\CrmSetting;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Modules\Crm\system_settings\models\SystemSetting;
use App\Modules\Crm\system_settings\models\SystemSettingsFormModel;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Support\Facades\Validator;
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

    static function assets(): array
    {
        return [
            ScheduleSettingsBundle::class
        ];
    }


    /**
     * Страница настроек CRM
     * @return mixed
     */
    public function actionCRMSettings()
    {
        $title = 'Настройки системы';
        $setting = BackendHelper::getSystemSettings(CrmSetting::getSettingName());

        $form = new SystemSettingsFormModel('settings_form', new FormAdditionalParam('POST', route('system_settings.crm_settings')));
        $form->load($setting->getSettings());

        if (request()->isMethod('POST')) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
        }
        ViewManager::appendElement($form);
        return view('system_settings::settings.crm_settings', compact('title'));
    }

    public function setCrmSettings()
    {
        $model = new CrmSetting();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if(request()->post() && $validate->validate()){
            $settings = json_encode($model->getData());
            BackendHelper::getOperations()->createSystemSettings(
                ['name'=>CrmSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>BackendHelper::getKernel()->getContext()->getUser()->id, 'active'=>true]
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
                ['name'=>SystemSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>BackendHelper::getKernel()->getContext()->getUser()->id, 'active'=>true]
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
                ['name'=>ScheduleSetting::getSettingName(), 'settings'=>$settings, 'create_user_id'=>BackendHelper::getKernel()->getContext()->getUser()->id, 'active'=>true]
            );
        }
        return redirect()->route('system_settings.schedule_settings');
    }
}
