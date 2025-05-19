<?php
namespace App\Modules\Crm\modules_settings\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class StatusModulesOperation extends AbstractOperation
{
    public function updateStatusModules($data)
    {
        foreach ($data as $module) {
            BackendHelper::getRepositories()->updateStatusModules($module['name'], $module['status']);
        }
        return true;
    }

    /**
     * Возвращает не добавленные модули
     * @return array
     */
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
                $info_module = BackendHelper::getKernel()->getModulByName($module)->getModule();
                if($info_module){
                    $not_in_modules_status[] = $info_module->getNameModule();
                }
            }
        }
        return $not_in_modules_status;
    }

    public function checkStatusModule($name_module)
    {
        $module = BackendHelper::getRepositories()->getModules(['name'=>$name_module]);
        if($module->count()&&$module[0]->active){
            return true;
        }
        return false;
    }

    public function getName(): string
    {
        return 'status_modules_operation';
    }
}
