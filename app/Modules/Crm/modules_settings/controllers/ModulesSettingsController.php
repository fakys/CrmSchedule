<?php
namespace App\Modules\Crm\modules_settings\controllers;

use App\Modules\Crm\modules_settings\InfoModule;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Mockery\Exception;

class ModulesSettingsController extends Controller{

    public function __construct()
    {
        (new InfoModule())->runConfig();
    }
    public function actionModulesSettings()
    {
        $config_module = BackendHelper::getOperations()->getDataModuleInNotStatusModules();
        $modules = BackendHelper::getOperations()->getDataModuleInNotStatusModules($config_module);
        return view('settings.modules_settings', compact('modules'));
    }

    public function actionAddModule()
    {
        $full_modules = BackendHelper::getOperations()->getDataModuleInNotConfigModules();
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
