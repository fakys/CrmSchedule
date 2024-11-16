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
        $arr_module = [];
        foreach ($modules as $module) {
            $arr_module[] = $module->name;
        }
        $config_modules = BackendHelper::getOperations()->getFullConfigModules();
        $not_in_modules_status = [];
        foreach ($config_modules as $module) {
            if (!in_array($module, $arr_module)) {
                $info_module = BackendHelper::getModule($module);
                if($info_module){
                    $not_in_modules_status[] = $info_module;
                }
            }
        }
        return $not_in_modules_status;
    }

    public function checkStatusModule($name_module)
    {
        $module = BackendHelper::getRepositories()->getModules(['name'=>$name_module[0]]);
        if($module&&$module[0]->active){
            return true;
        }
        return false;
    }
}
