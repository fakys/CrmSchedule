<?php
namespace App\Modules\Crm\modules_settings\operations;

use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\operations\AbstractOperation;

class ConfigModulesOperations extends AbstractOperation
{
    public function getFullConfigModules()
    {
        $modules = config('modules.modules');
        $full_modules = [];
        foreach ($modules as $name_module=>$module) {
            $full_modules = array_merge($module, $full_modules);
        }
        return $full_modules;
    }
    public function getInfoModuleSettings()
    {
        $modules = BackendHelper::getRepositories()->getFullModuleSettings();
        $info_modules = [];
        foreach ($modules as $name_module=>$module) {
            $info_modules[]=['module'=>BackendHelper::getModule($module->name),'status_module'=>$module->active];
        }
        return $info_modules;
    }

    public function getName(): string
    {
        return 'config_modules_operations';
    }
}
