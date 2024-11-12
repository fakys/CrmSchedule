<?php
namespace App\Modules\Crm\modules_settings\operations;

use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\operations\Operation;

class ConfigModulesOperations extends Operation
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

    public function getDataModuleInNotConfigModules()
    {
        $modules = BackendHelper::getRepositories()->getFullModuleSettings();
        $config_modules = $this->getFullConfigModules();
        $not_in_modules_status = [];
        foreach ($modules as $module) {
            if (!in_array($module->name, $config_modules)) {
                $not_in_modules_status[] = [
                    'status_module' => $module->active,
                    'module' => BackendHelper::getModule($module->name)
                ];
            }
        }
        return $not_in_modules_status;
    }

}
