<?php
namespace App\Modules\Crm\modules_settings\operations;

use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\kernel\KernelModules;
use App\Src\modules\operations\AbstractOperation;

class ConfigModulesOperations extends AbstractOperation
{
    public function getFullConfigModules()
    {
        $modules = app()->get(KernelModules::MODULE_KEY);
        $full_modules = [];
        foreach ($modules as $name_module=>$module) {
            $full_modules[] = $name_module;
        }
        return $full_modules;
    }
    public function getInfoModuleSettings()
    {
        $modules = BackendHelper::getRepositories()->getFullModuleSettings();
        $info_modules = [];
        foreach ($modules as $name_module=>$module) {
            $info_modules[]=['module'=>BackendHelper::getKernel()->getModuleByName($module->name)->getModule(),'status_module'=>$module->active];
        }
        return $info_modules;
    }

    public function getName(): string
    {
        return 'config_modules_operations';
    }
}
