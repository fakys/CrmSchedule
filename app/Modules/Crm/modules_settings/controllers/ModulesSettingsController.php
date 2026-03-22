<?php
namespace App\Modules\Crm\modules_settings\controllers;

use App\Modules\Crm\modules_settings\assets\SystemSettingsBundle;
use App\Modules\Crm\modules_settings\InfoModule;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Mockery\Exception;

class ModulesSettingsController extends AbstractController {

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmLink('modules')
            ->setText('Модули')
            ->setIcon('fa fa-sitemap')
            ->setLink(route('modules_settings.settings'));
    }

    static function assets(): array
    {
        return [
            SystemSettingsBundle::class
        ];
    }


    public function actionModulesSettings()
    {
        $modules = BackendHelper::getOperations()->getInfoModuleSettings();
        return view('modules_settings::settings.modules_settings', compact('modules'));
    }

    public function saveStatusModules()
    {
        $data = request()->post('data');
        return BackendHelper::getOperations()->updateStatusModules($data);
    }
}
