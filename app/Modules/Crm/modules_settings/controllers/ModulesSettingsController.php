<?php
namespace App\Modules\Crm\modules_settings\controllers;

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


    public function actionModulesSettings()
    {
        $modules = BackendHelper::getOperations()->getInfoModuleSettings();
        return view('settings.modules_settings', compact('modules'));
    }

    public function actionAddModule()
    {
        $full_modules = ArrayHelper::valueIsKey(BackendHelper::getOperations()->getDataModuleInNotStatusModules());
        return view('settings.add_module', compact('full_modules'));
    }
    public function saveModule()
    {
        if(isset(request()->post()['modules'])){
            $config_modules = BackendHelper::getOperations()->getFullConfigModules();
            $modules = request()->post()['modules'];
            $active = isset(request()->post()['active_modules'])?request()->post()['active_modules']:false;
            foreach ($modules as $module) {
                if(in_array($module, $config_modules)){
                    if($active){
                        BackendHelper::getRepositories()->createStatusModules(['name'=>$module, 'active'=>true]);
                    }else{
                        BackendHelper::getRepositories()->createStatusModules(['name'=>$module, 'active'=>false]);
                    }

                }
            }
        }
        return redirect()->route('modules_settings.settings');
    }

    public function saveStatusModules()
    {
        $data = request()->post('data');
        return BackendHelper::getOperations()->updateStatusModules($data);
    }
}
