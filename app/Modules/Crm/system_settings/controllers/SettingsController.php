<?php
namespace App\Modules\Crm\system_settings\controllers;

use App\Modules\Crm\system_settings\assets\ScheduleSettingsBundle;
use App\Modules\Crm\system_settings\components\settings\CrmSetting;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Modules\Crm\system_settings\components\settings\SystemSetting;
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
        $title = 'Настройки Сrm';
        $setting = BackendHelper::getSystemSettings(CrmSetting::SETTING_NAME);

        $form = new SystemSettingsFormModel('settings_form', new FormAdditionalParam('POST', route('system_settings.crm_settings')));
        $form->load($setting->getSettings());

        if (request()->isMethod('POST')) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $setting->loadSettings($form->getReturnData()->toArray());
        }
        ViewManager::appendElement($form);
        return view('system_settings::settings.crm_settings', compact('title'));
    }

    /**
     * Страница системных настроек
     * @return mixed
     */
    public function actionSystemSettings()
    {
        $title = 'Настройки Сrm';
//        $groups = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
//        $users = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllActiveUsers(), 'username', 'id');
        /** @var SystemSetting $setting */
        $setting = BackendHelper::getSystemSettings(SystemSetting::SETTING_NAME);
        $form = new SystemSettingsFormModel('settings_form', new FormAdditionalParam('POST', route('system_settings.settings')));
        $form->load($setting->getSettings());

        if (request()->isMethod('POST')) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $setting->loadSettings($form->getReturnData()->toArray());
        }
        ViewManager::appendElement($form);
        return view('system_settings::settings.system_settings', compact('title'));
    }

    public function actionScheduleSettings()
    {
        $settings = BackendHelper::getSystemSettings(ScheduleSetting::SETTING_NAME);
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
}
