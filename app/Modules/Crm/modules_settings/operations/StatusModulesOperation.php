<?php
namespace App\Modules\Crm\modules_settings\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class StatusModulesOperation extends Operation
{
    public function updateStatusModules(array $data)
    {
        foreach ($data[0] as $module) {
            BackendHelper::getRepositories()->updateStatusModules($module);
        }
        return true;
    }
    public function getDataModuleInNotStatusModules()
    {
        $modules = BackendHelper::getRepositories()->getFullModuleSettings();
        $config_modules = BackendHelper::getOperations()->getFullConfigModules();
        $not_in_modules_status = [];
        foreach ($modules as $module) {
            if (in_array($module->name, $config_modules)) {
                $not_in_modules_status[] = [
                    'status_module' => $module->active,
                    'module' => BackendHelper::getModule($module->name)
                ];
            }
        }
        return $not_in_modules_status;
    }
}
